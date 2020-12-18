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

use hiqdev\DataMapper\Validator\IntegerValidator;

class IntegerAttribute extends AbstractAttribute
{
    public function getOperatorRules()
    {
        return [
            'eq' => [IntegerValidator::class],
            'ne' => [IntegerValidator::class],
            'gt' => [IntegerValidator::class],
            'lt' => [IntegerValidator::class],
            'in' => ['each', 'rule' => [IntegerValidator::class]],
            'ni' => ['each', 'rule' => [IntegerValidator::class]],
        ];
    }
}
