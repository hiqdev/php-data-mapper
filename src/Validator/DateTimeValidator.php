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

use DateTime;
use DateTimeZone;
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
        if (strpos($value, 'T', true) !== false) {
            $datetime = $this->parseExtendedDateValue($value);
        } else {
            $datetime = parent::parseDateValue($value);
        }

        return $datetime ?: strtotime($value);
    }

    /**
     * @return bool|int
     */
    private function parseExtendedDateValue(string $value)
    {
        $value = str_replace(" ", "+", $value);
        $date = DateTime::createFromFormat("Y-m-d\TH:i:sT", $value, new DateTimeZone($this->timeZone));
        $errors = DateTime::getLastErrors();
        if ($date === false || !empty($errors['error_count']) || !empty($errors['warning_count'])) {
            return false;
        }

        return $date->getTimestamp();
    }
}
