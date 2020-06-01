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

/**
 * Class FloatAttribute.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class FloatAttribute extends AbstractAttribute
{
    public function getOperatorRules()
    {
        return [
            'eq' => ['number'],
            'ne' => ['number'],
            'gt' => ['number'],
            'lt' => ['number'],
            'in' => ['each', 'rule' => ['number']],
            'ni' => ['each', 'rule' => ['number']],
        ];
    }
}
