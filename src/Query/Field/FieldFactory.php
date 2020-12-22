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

use hiqdev\DataMapper\Attribution\AttributionInterface;

class FieldFactory implements FieldFactoryInterface
{
    /**
     * @param AttributionInterface $model
     * @param $map
     * @param string[] parent attribute names
     * @return Field[]
     */
    public function createByAttribution($model, $map, array $parents = [])
    {
        $result = [];

        foreach ($map as $attributeName => $definition) {
            if (is_array($definition)) {
                $relationClass = $model->getRelation($attributeName);
                $result = array_merge($result, $this->createByAttribution(
                    new $relationClass(),
                    $definition,
                    array_merge($parents, [$attributeName])
                ));
                continue;
            }

            if ($definition instanceof FieldInterface) {
                $result[] = $definition;
            } else {
                $result[] = $this->buildField($model, $attributeName, $definition, $parents);
            }
        }

        return $result;
    }

    /**
     * @param AttributionInterface $model
     * @param string $attributeName
     * @param string $sql
     * @return Field
     */
    protected function buildField($model, $attributeName, $sql, array $parents)
    {
        array_push($parents, $attributeName);
        $name = implode($this->getHierarchySeparator(), $parents);

        return new Field($name, $sql, $model->getAttribute($attributeName));
    }

    public function getHierarchySeparator(): string
    {
        return '-';
    }
}
