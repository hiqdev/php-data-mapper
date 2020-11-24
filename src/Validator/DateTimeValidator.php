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

use yii\validators\DateValidator;

class DateTimeValidator extends DateValidator implements NormalizerInterface
{
    public $type = self::TYPE_DATETIME;

    public $format = 'php:Y-m-d H:i:s';

    public function normalize($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    protected function parseDateValue($value)
    {
        $datetime = parent::parseDateValue($value);

        return $datetime ?: strtotime($value);
    }
}
