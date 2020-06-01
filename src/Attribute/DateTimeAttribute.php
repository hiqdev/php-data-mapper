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

use hiqdev\DataMapper\Query\attributes\validators\DateTimeValidator;

class DateTimeAttribute extends AbstractAttribute
{
    protected function getOperatorRules()
    {
        return [
            'eq' => [DateTimeValidator::class],
        ];
    }
}
