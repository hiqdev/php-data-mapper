<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\Field;

interface FieldFactoryInterface
{
    /**
     * @param $attribution
     * @param $map
     * @return Field[]
     */
    public function createByAttribution($attribution, $map);

    /**
     * @return string
     */
    public function getHierarchySeparator(): string;
}
