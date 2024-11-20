<?php
declare(strict_types=1);
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Validator;

use yii\validators\NumberValidator;

class IntegerValidator extends NumberValidator implements NormalizerInterface
{
    public function __construct($config = [])
    {
        $config['integerOnly'] = true;

        parent::__construct($config);
    }

    public function normalize($value)
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        return null;
    }
}
