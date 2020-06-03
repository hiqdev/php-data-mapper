<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Attribute;

class StringAttribute extends AbstractAttribute
{
    public function getOperatorRules()
    {
        return [
            'eq' => ['string'],
            'ne' => ['string'],
            'in' => ['each', 'rule' => ['string']],
            'ni' => ['each', 'rule' => ['string']],
            'like' => ['string'],
            'ilike' => ['string'],
        ];
    }
}
