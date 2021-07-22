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

use hiqdev\DataMapper\Query\Field\FieldInterface;
use hiqdev\DataMapper\Validator\AttributeValidationException;

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
     * @param FieldInterface $field
     * @param string $attribute The attribute name in the WHERE condition
     * @param mixed $value The value, being filtered
     * @return mixed
     * @throws AttributeValidationException in the attribute value does not pass the field type validation
     */
    public function build(FieldInterface $field, string $attribute, $value);

    /**
     * Checks, whether the $field is responsible for $attribute filter.
     *
     * @param FieldInterface $field
     * @param string $attribute
     * @param mixed $value
     * @return bool|null True/False – when $field is responsible for $attribute filter
     *                   Null – when QueryConditionBuilder can not decide on it and needs
     *                          to delegate it.
     */
    public function canApply(FieldInterface $field, string $attribute, $value): ?bool;
}
