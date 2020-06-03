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

use Exception;
use hiqdev\DataMapper\Repository\BaseRepository;

interface EntityManagerInterface
{
    /**
     * @param string $entityClass
     * @throws Exception when repository is not defined for the $entityClass
     * @return BaseRepository
     */
    public function getRepository($entityClass);

    public function save($entity);

    /**
     * @param object|string $object entity or class name
     * @return object
     */
    public function hydrate(array $data, $object);
}
