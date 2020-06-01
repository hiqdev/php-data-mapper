<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\Builder;

/**
 * Interface QueryConditionBuilderFactoryInterface
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface QueryConditionBuilderFactoryInterface
{
    /**
     * Builds a QueryConditionBuilder
     *
     * @psalm-param class-string<QueryConditionBuilderInterface> $className
     */
    public function build(string $className): QueryConditionBuilderInterface;
}
