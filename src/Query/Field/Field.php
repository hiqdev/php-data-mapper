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

use hiqdev\DataMapper\Attribute\AbstractAttribute;
use hiqdev\DataMapper\Attribute\AttributeInterface;
use hiqdev\DataMapper\Query\Builder\QueryConditionBuilderInterface;
use yii\db\ExpressionInterface;

class Field implements FieldInterface, SQLFieldInterface, AttributedFieldInterface, BuilderAwareFieldInterface
{
    /**
     * @var string field (attribute) name
     */
    protected $name;

    /**
     * @var string|ExpressionInterface representing column name in SQL
     */
    protected $sql;

    /**
     * @var AbstractAttribute
     */
    protected $attribute;

    /**
     * @var class-string<QueryConditionBuilderInterface>|null
     */
    protected $builderClass;

    /**
     * Field constructor.
     *
     * @param string $name
     * @param string $sql
     */
    public function __construct($name, $sql, AbstractAttribute $attribute)
    {
        $this->name = $name;
        $this->sql = $sql;
        $this->attribute = $attribute;
    }

    public function canBeSelected(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @return AbstractAttribute
     */
    public function getAttribute(): AttributeInterface
    {
        return $this->attribute;
    }

    public function buildWith(string $className)
    {
        $self = clone $this;
        $self->builderClass = $className;

        return $self;
    }

    public function getBuilderClass(): ?string
    {
        return $this->builderClass;
    }
}
