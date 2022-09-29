<?php
declare(strict_types=1);

/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Attribution;

use RuntimeException;

class CompositeBucket
{
    /**
     * @var array
     */
    protected $items = [];
    /**
     * @var array<string> The list of keys to be used as a composite key.
     */
    private $sourceKeys;
    /**
     * @var array Entities that were found by the bucket keys.
     */
    private array $entities;
    /**
     * @var array<string, array> the map of entity keys to bucket keys. The key is the entity key, the value is the bucket key.
     * For example, if the entity has a key `id` and the bucket has a key `user_id`, the map will be `['id' => 'user_id']`.
     */
    private array $keyMap;
    /**
     * @var string|null the attribute name that is a primary key of the {@see entities} and will be used for one-to-many relation.
     */
    private ?string $entityIdKey = null;

    /**
     * Bucket constructor.
     *
     * @param array<string> $sourceKeys
     */
    public function __construct(array $sourceKeys)
    {
        $this->sourceKeys = $sourceKeys;
    }

    /**
     * @param array[] $rows
     * @param array<string> $sourceKeys
     * @return static
     */
    public static function fromRows($rows, array $sourceKeys): self
    {
        $bucket = new static($sourceKeys);
        $bucket->initialize($rows);

        return $bucket;
    }

    protected function initialize($rows): void
    {
        $result = array_fill_keys(array_keys($this->sourceKeys), []);

        foreach ($rows as $row) {
            foreach ($this->sourceKeys as $sourceKey) {
                $value = $row[$sourceKey];
                if ($value === null) {
                    continue;
                }
                $result[$sourceKey][$value] = [];
            }
        }

        $this->items = $result;
    }

    /**
     * Fills current bucket with $entities.
     *
     * @param array $entities
     * @param array<string, string> $keyMap the map of entity keys to bucket keys. The key is the entity key, the value is the bucket key.
     * For example, if the entity has a key `id` and the bucket has a key `user_id`, the map will be `['id' => 'user_id']`.
     *
     * @param string|null $entityIdKey the attribute name that is a primary key of the $entity and will be used for one-to-many relation
     * Optional. In case `null`, identifiers will be sequential.
     */
    public function fill($entities, array $keyMap, $entityIdKey = null): void
    {
        $this->entities = $entities;
        $this->keyMap = $keyMap;
        $this->entityIdKey = $entityIdKey;
    }

    public function pour(&$rows, $relationName): void
    {
        foreach ($rows as &$row) {
            foreach ($this->entities as $entity) {
                $match = true;
                foreach ($this->keyMap as $entityKey => $bucketKey) {
                    if ($row[$bucketKey] !== $entity[$entityKey]) {
                        $match = false;
                        break;
                    }
                }
                if ($match) {
                    if ($this->entityIdKey !== null) {
                        $row[$relationName][$entity[$this->entityIdKey]] = $entity;
                    } else {
                        $row[$relationName][] = $entity;
                    }
                    continue 2;
                }
            }

            $row[$relationName] = null;
        }
    }

    public function getKeys(string $key): array
    {
        if (!isset($this->items[$key])) {
            throw new RuntimeException(sprintf('Key "%s" is not found in bucket', $key));
        }

        return array_keys($this->items[$key] ?? []);
    }
}
