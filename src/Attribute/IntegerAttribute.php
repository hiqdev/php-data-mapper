<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\attributes;

class IntegerAttribute extends AbstractAttribute
{
    public function getOperatorRules()
    {
        return [
            'eq' => ['number', 'integerOnly' => true],
            'ne' => ['number', 'integerOnly' => true],
            'gt' => ['number', 'integerOnly' => true],
            'lt' => ['number', 'integerOnly' => true],
            'in' => ['each', 'rule' => ['number', 'integerOnly' => true]],
            'ni' => ['each', 'rule' => ['number', 'integerOnly' => true]],
        ];
    }
}
