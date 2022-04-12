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

use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorAwareTrait;

abstract class GeneratedHydrator extends AbstractHydrator implements ObjectFactoryInterface, HydratorAwareInterface
{
    use GeneratedHydratorTrait;
    use ObjectFactoryTrait;
    use HydratorAwareTrait;
}
