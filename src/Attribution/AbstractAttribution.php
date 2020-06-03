<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Attribution;

use hiqdev\DataMapper\Attribute\AttributeInterface;
use hiqdev\DataMapper\Schema\Relation;
use RuntimeException;

/**
 * Class AbstractModel.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
abstract class AbstractAttribution implements AttributionInterface
{
    public function hasAttribute(string $name): bool
    {
        return isset($this->attributes()[$name]);
    }

    public function hasRelation(string $name): bool
    {
        return isset($this->relations()[$name]);
    }

    /**
     * @param string $name
     * @throws RuntimeException
     * @return string
     */
    public function getRelation($name)
    {
        if (!$this->hasRelation($name)) {
            throw new RuntimeException('Relation "' . $name . '" is not available within ' . static::class);
        }

        $relation = $this->relations()[$name];
        if (is_string($relation)) {
            return $relation;
        }

        return $relation[Relation::TARGET];
    }

    /**
     * @param $name
     * @throws RuntimeException
     */
    public function getAttribute(string $name): AttributeInterface
    {
        if (!$this->hasAttribute($name)) {
            throw new RuntimeException('Attribute "' . $name . '" is not available within ' . static::class);
        }

        $className = $this->attributes()[$name];

        if (is_object($className)) {
            return $className;
        }

        return new $className();
    }
}
