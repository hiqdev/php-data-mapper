<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\Field;

use hiqdev\DataMapper\Attribute\AttributeInterface;

/**
 * Interface AttributedFieldInterface marks a field with the attribute
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface AttributedFieldInterface extends FieldInterface
{
    /**
     * The returns attribute, that describes the value type.
     */
    public function getAttribute(): AttributeInterface;
}
