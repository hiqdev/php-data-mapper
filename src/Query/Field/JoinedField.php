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

final class JoinedField implements FieldInterface, JoinedFieldInterface, SQLFieldInterface
{
    private SQLFieldInterface $field;
    private string         $joinName;

    public function __construct(SQLFieldInterface $field, string $joinName)
    {
        $this->field = $field;
        $this->joinName = $joinName;
    }

    public function getJoinName(): string
    {
        return $this->joinName;
    }

    public function getName(): string
    {
        return $this->field->getName();
    }

    public function getSql()
    {
        return $this->field->getSql();
    }

    public function canBeSelected(): bool
    {
        return $this->field->canBeSelected();
    }
}
