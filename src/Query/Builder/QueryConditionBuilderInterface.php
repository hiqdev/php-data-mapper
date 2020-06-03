<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\Builder;

use hiqdev\DataMapper\Validator\AttributeValidationException;
use hiqdev\DataMapper\Query\Field\FieldInterface;

/**
 * Interface QueryConditionBuilderInterface described a class
 * that is response for creating conditions on the specific Field
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface QueryConditionBuilderInterface
{
    /**
     * Builds a condition in one of the Yii-compatible `where` formats.
     *
     * @param $value
     * @throws AttributeValidationException in the attribute value does not pass the field type validation
     * @return mixed
     */
    public function build(FieldInterface $field, string $attribute, $value);

    /**
     * Checks, whether the $field is responsible for $attribute filter.
     */
    public function canApply(FieldInterface $field, string $attribute): bool;
}
