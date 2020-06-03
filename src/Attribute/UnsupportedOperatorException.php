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

class UnsupportedOperatorException extends \hiqdev\DataMapper\Validator\AttributeValidationException
{
    public static function forOperator($operator)
    {
        return new static('Operator ' . $operator . ' is not supported');
    }
}
