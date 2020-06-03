<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Validator;

use hiapi\commands\SearchCommand;
use hiqdev\DataMapper\Attribute\AttributeInterface;
use hiqdev\DataMapper\Attribution\AttributionInterface;
use hiqdev\DataMapper\Repository\EntityManagerInterface;
use yii\validators\Validator;

class WhereValidator extends Validator
{
    /**
     * @var string
     */
    public $targetEntityClass;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, array $config = [])
    {
        $this->em = $em;

        parent::__construct($config);
    }

    /**
     * @param SearchCommand $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute): bool
    {
        $where = $model->$attribute;

        $attribution = $this->getAttribution();
        $dynamicAttribution = $this->buildDynamicAttribution($attribution);
        $dynamicAttribution->load($where, '');
        if (!$dynamicAttribution->validate()) {
            $model->addErrors($dynamicAttribution->getErrors());

            return false;
        }
        // TODO: put back to $model->$attribute only validated data
        // $model->$attribute = $dynamicAttribution->toArray(); // except nulls

        return true;
    }

    private function getAttribution(): AttributionInterface
    {
        return $this->em->getRepository($this->targetEntityClass)
            ->buildQuery()
            ->getAttribution();
    }

    private function buildDynamicAttribution(AttributionInterface $attribution): DynamicValidationModel
    {
        return $this->unwrapAttributes($attribution);
    }

    private function unwrapAttributes(AttributionInterface $attribution, array $parents = []): ?DynamicValidationModel
    {
        if ($this->circularReferenceDetected($parents)) {
            return null;
        }

        $dynamicAttribution = new DynamicValidationModel();
        foreach ($attribution->attributes() as $baseAttributeName => $attributeClassName) {
            /** @var AttributeInterface $attribute */
            $attribute = new $attributeClassName();
            foreach ($attribute->getSupportedOperators() as $operator) {
                $attributeName = $baseAttributeName . ($operator === '' ? '' : "_$operator");
                $dynamicAttribution->defineAttribute($attributeName);

                $rule = $attribute->getRuleForOperator($operator);
                $validatorName = array_shift($rule);
                $dynamicAttribution->addRule($attributeName, $validatorName, $rule);
            }
        }

        foreach ($attribution->relations() as $relationName => $relationClassName) {
            $parents[] = [$relationName, $relationClassName];
            $relation = $this->unwrapAttributes(new $relationClassName(), $parents);
            if ($relation === null) {
                continue;
            }
            $dynamicAttribution->defineAttribute($relationName, $relation);
        }

        return $dynamicAttribution;
    }

    private int $relationNestingLimit = 3;

    /**
     * @psalm-param list<array{0: string, 1: class-name<AttributionInterface>}> $parents
     */
    private function circularReferenceDetected(array $parents): bool
    {
        $count = 0;
        $lastRelation = array_pop($parents);
        foreach ($parents as $parent) {
            if ($parent === $lastRelation) {
                ++$count;
            }

            if ($count === $this->relationNestingLimit) {
                return true;
            }
        }

        return false;
    }
}
