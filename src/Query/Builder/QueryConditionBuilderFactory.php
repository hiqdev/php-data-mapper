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

namespace hiqdev\DataMapper\Query\Builder;

use Psr\Container\ContainerInterface;

final class QueryConditionBuilderFactory implements QueryConditionBuilderFactoryInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function build(string $className): QueryConditionBuilderInterface
    {
        return $this->container->get($className);
    }
}
