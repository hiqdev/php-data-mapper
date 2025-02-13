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

use hiqdev\DataMapper\Events\EntitiesSavedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use yii\di\Container;
use Laminas\Hydrator\HydratorInterface;

class EntityManager implements EntityManagerInterface
{
    /**
     * @var BaseRepository[]
     */
    public $repositories = [];

    /**
     * @var array map: repository => class
     */
    protected $entities;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var Container
     */
    protected $di;

    protected ?EventDispatcherInterface $eventDispatcher;

    public function __construct(
        Container $di,
        HydratorInterface $hydrator,
        ?EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->di = $di;
        $this->hydrator = $hydrator;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEntityClass($repo)
    {
        $class = is_object($repo) ? get_class($repo) : $repo;
        $entities = $this->getEntities();
        if (!empty($entities[$class])) {
            return $entities[$class];
        }

        foreach ($entities as $repoClass => $entityClass) {
            if (is_a($repo, $repoClass)) {
                return $entityClass;
            }
        }

        throw new \Exception('no entity class for ' . $class);
    }

    protected function getEntities()
    {
        if ($this->entities === null) {
            foreach ($this->repositories as $entityClass => $repo) {
                $repoClass = is_object($repo) ? get_class($repo) : $repo;
                $this->entities[$repoClass] = $entityClass;
            }
        }

        return $this->entities;
    }

    /**
     * Get entity repository by entity or class.
     * @param object|string $entityClass entity or class
     * @return BaseRepository
     */
    public function getRepository($entityClass)
    {
        if (is_object($entityClass)) {
            $entityClass = get_class($entityClass);
        }

        if (!isset($this->repositories[$entityClass])) {
            throw new \Exception("no repository defined for: $entityClass");
        }

        if (!is_object($this->repositories[$entityClass])) {
            $this->repositories[$entityClass] = $this->di->get($this->repositories[$entityClass]);
        }

        return $this->repositories[$entityClass];
    }

    /**
     * Save given entity into it's repository.
     * @param object $entity
     */
    public function save($entity)
    {
        $repo = $this->getRepository($entity);
        $repo->save($entity);
    }

    /**
     * Save given entities into it's repository.
     */
    public function saveAll(array $entities)
    {
        /// TODO add transaction
        /// $this->db->transaction(function() use ($entities) {
        /// });
        foreach ($entities as $entity) {
            $this->save($entity);
        }

        // Dispatch event after all entities are saved
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(new EntitiesSavedEvent($entities));
        }
    }

    /**
     * @param object|string $object entity or class name
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        return $this->hydrator->hydrate($data, $object);
    }

    public function extract($object)
    {
        return $this->hydrator->extract($object);
    }

    /**
     * XXX TODO think of the whole process:
     * alternative: find and populate whole entity.
     * @param object $entity
     * @return string|int
     */
    public function findId($entity)
    {
        return $this->getRepository($entity)->findId($entity);
    }
}
