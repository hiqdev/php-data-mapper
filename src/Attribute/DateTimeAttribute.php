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

use hiqdev\DataMapper\Validator\DateTimeValidator;

class DateTimeAttribute extends AbstractAttribute
{
    protected function getOperatorRules()
    {
        return [
            'eq' => [DateTimeValidator::class],
            'in' => ['each', 'rule' => [DateTimeValidator::class]],
            'ni' => ['each', 'rule' => [DateTimeValidator::class]],
        ];
    }
}
