<?php
/**
 * Data Mapper for Yii2
 *
 * @link      https://github.com/hiqdev/yii2-data-mapper
 * @package   yii2-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Validator;

class AttributeValidator implements \hiqdev\DataMapper\Validator\NormalizerInterface
{
    /**
     * @var \yii\validators\Validator
     */
    private $realValidator;

    public function __construct($realValidator)
    {
        $this->realValidator = $realValidator;
    }

    /**
     * @param mixed $value
     * @return bool whether value is valid
     */
    public function validate($value)
    {
        return $this->realValidator->validate($value);
    }

    /**
     * @param mixed $value
     * @throws AttributeValidationException when value is not valid
     */
    public function ensureIsValid($value)
    {
        if ($value === null) {
            return;
        }
        if ($value instanceof \yii\db\ExpressionInterface) {
            return;
        }
        if ($this->realValidator->validate($value, $result) !== true) {
            throw \hiqdev\DataMapper\Validator\AttributeValidationException::forValue($value, $result);
        }
    }

    public function normalize($value)
    {
        if ($this->realValidator instanceof \hiqdev\DataMapper\Validator\NormalizerInterface) {
            $value = $this->realValidator->normalize($value);
        }

        return $value;
    }
}
