<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query;

interface FieldFactoryInterface
{
    /**
     * @param $model
     * @param $map
     * @return Field[]
     */
    public function createByModelAttributes($model, $map);

    /**
     * @return string
     */
    public function getHierarchySeparator();
}
