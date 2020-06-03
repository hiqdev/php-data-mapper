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

use hiqdev\DataMapper\Validator\AttributeValidator;

interface AttributeValidatorFactoryInterface
{
    /**
     * @param string|array $definition
     */
    public function createByDefinition($definition): AttributeValidator;
}
