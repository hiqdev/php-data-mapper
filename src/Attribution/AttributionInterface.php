<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\models;

use hiqdev\DataMapper\Query\attributes\AbstractAttribute;
use hiqdev\DataMapper\Query\attributes\AttributeInterface;

interface ModelInterface
{
    /**
     * @psalm-return array<string, class-string<self>>
     */
    public function relations();

    /**
     * @psalm-return class-string<self>
     * // TODO: handle one-to-many relations
     */
    public function getRelation(string $name);

    public function hasRelation(string $name): bool;

    /**
     * @return array<string, class-string<AttributeInterface>>
     */
    public function attributes();

    /**
     * @psalm-return AttributeInterface
     */
    public function getAttribute(string $name): AbstractAttribute;

    public function hasAttribute(string $name): bool;
}
