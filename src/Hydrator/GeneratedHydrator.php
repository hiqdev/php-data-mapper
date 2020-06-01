<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Hydrator;

use Zend\Hydrator\HydratorInterface;

abstract class GeneratedHydrator implements HydratorInterface
{
    use RootHydratorAwareTrait;
    use GeneratedHydratorTrait;
}
