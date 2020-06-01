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

use hiqdev\DataMapper\Query\Specification;

/**
 * Interface GenericRepositoryInterface.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface GenericRepositoryInterface
{
    /**
     * @return object[]
     */
    public function findAll(Specification $specification);

    /**
     * @return object|false
     */
    public function findOne(Specification $specification);

    /**
     * @throws EntityNotFoundException
     * @return object
     */
    public function findOneOrFail(Specification $specification);
}
