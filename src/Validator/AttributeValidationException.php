<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Validator;

class AttributeValidationException extends \RuntimeException
{
    public function getName()
    {
        return 'Validation exception';
    }

    public static function forValue($value, $message)
    {
        return new self('Value ' . json_encode($value) . ' is invalid');
    }
}
