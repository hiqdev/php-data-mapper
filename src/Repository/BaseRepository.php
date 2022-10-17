<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Repository;

use hiqdev\DataMapper\Query\Query;
use hiqdev\DataMapper\Query\Specification;
use hiqdev\yii\compat\yii;
use yii\base\Component;

abstract class BaseRepository extends Component implements RepositoryInterface
{
    /**
     * @var class-string<Query>
     */
    public $queryClass;

    public function __construct(protected ConnectionInterface $db, protected EntityManagerInterface $em, array $config = [])
    {
        parent::__construct($config);
    }

    public function findByUniqueness(array $entities): array
    {
        return $this->findByIds($this->findIds($entities));
    }

    public function findIds(array $entities): array
    {
        $ids = [];
        foreach ($entities as $entity) {
            $id = $this->findId($entity);
            if ($id) {
                $ids[$id] = $id;
            }
        }

        return $ids;
    }

    /**
     * Selects single entity from DB by given ID.
     * @param string|int $id
     * @return ?object
     */
    public function findById($id): ?object
    {
        $all = $this->findByIds([$id]);

        return empty($all) ? null : reset($all);
    }

    /**
     * Selects entities from DB by given IDs.
     * @param string[] $ids
     */
    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $spec = $this->createSpecification()->where(['id' => $ids]);

        return $this->findAll($spec);
    }

    public function setRecordClass($value)
    {
        $this->recordClass = $value;
    }

    public function getRecordClass()
    {
        if ($this->recordClass === null) {
            $this->recordClass = $this->findRecordClass();
        }

        return $this->recordClass;
    }

    public function findRecordClass()
    {
        $parts = explode('\\', get_called_class());

        return implode('\\', $parts);
    }

    /**
     * @return object[]
     */
    public function findAll(Specification $specification)
    {
        $rows = $this->queryAll($specification);

        return $this->hydrateMultiple($rows);
    }

    public function count(Specification $specification)
    {
        return $this->buildSelectQuery($specification)->count('*', $this->db);
    }

    public function queryAll(Specification $specification)
    {
        $query = $this->buildSelectQuery($specification);
        $rows = $query->createCommand($this->db)->queryAll();
        $rows = array_map(function ($row) use ($query) {
            return $query->restoreHierarchy($row);
        }, $rows);

        return $this->findAllRelations($specification, $rows);
    }

    /**
     * @param Specification $specification TODO use type hint
     * @return object|false
     */
    public function findOne($specification)
    {
        $rows = $this->findAll($specification->limit(1));

        return reset($rows);
    }

    /**
     * @throws EntityNotFoundException when entity was not found
     * @return false|object
     */
    public function findOneOrFail(Specification $specification)
    {
        $result = $this->findOne($specification);
        if ($result === false) {
            throw new EntityNotFoundException();
        }

        return $result;
    }

    public function findAllRelations(Specification $specification, array $rows)
    {
        if (!is_array($specification->with) || empty($rows)) {
            return $rows;
        }

        foreach ($specification->with as $relationName) {
            $this->joinRelation($relationName, $rows);
        }

        return $rows;
    }

    protected function joinRelation($relationName, &$rows)
    {
        $method = 'join' . $relationName;
        if (!method_exists($this, $method)) {
            throw new \RuntimeException("Do not know how to join relation '$relationName'");
        }
        $this->$method($rows);
    }

    protected function buildSelectQuery(Specification $specification)
    {
        return $this->buildQuery()
            ->initSelect()
            ->apply($specification);
    }

    public function buildQuery(): Query
    {
        return yii::createObject($this->getQueryClass());
    }

    /**
     * @psalm-return class-string<Query>
     */
    public function getQueryClass(): string
    {
        return $this->queryClass;
    }

    /**
     * @param array $rows
     * @param object|string $entityClass
     * @return object[]
     */
    public function hydrateMultiple($rows, $entityClass = null)
    {
        $entities = [];
        foreach ($rows as $row) {
            $entities[] = $this->hydrate($row, $entityClass);
        }

        return $entities;
    }

    /**
     * @param object|string $object object or class name
     * @return object
     */
    public function hydrate(array $data, $object = null)
    {
        return $this->em->hydrate($data, $object ?? $this->getEntityClass());
    }

    public function getEntityClass()
    {
        return $this->em->getEntityClass($this);
    }

    /**
     * @param $entityClass
     * @return BaseRepository
     */
    public function getRepository($entityClass)
    {
        return $this->em->getRepository($entityClass);
    }

    public function createSpecification(): Specification
    {
        return new Specification();
    }
}
