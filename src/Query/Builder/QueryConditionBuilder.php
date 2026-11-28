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

use hiqdev\DataMapper\Attribute\AttributeInterface;
use hiqdev\DataMapper\Query\Field\AttributedFieldInterface;
use hiqdev\DataMapper\Query\Field\BuilderAwareFieldInterface;
use hiqdev\DataMapper\Query\Field\FieldConditionBuilderInterface;
use hiqdev\DataMapper\Query\Field\FieldInterface;
use hiqdev\DataMapper\Query\Field\SQLFieldInterface;
use hiqdev\DataMapper\Validator\AttributeValidationException;
use hiqdev\DataMapper\Validator\AttributeValidator;
use hiqdev\DataMapper\Validator\AttributeValidatorFactoryInterface;

final class QueryConditionBuilder implements QueryConditionBuilderInterface
{
    private AttributeValidatorFactoryInterface $attributeValidatorFactory;
    private QueryConditionBuilderFactoryInterface $conditionBuilderFactory;
    private AttributeParserInterface $attributeParser;

    private array $builderMap;

    public function __construct(
        $builderMap,
        QueryConditionBuilderFactoryInterface $conditionBuilderFactory,
        AttributeValidatorFactoryInterface $attributeValidatorFactory,
        AttributeParserInterface $attributeParser
    ) {
        $this->attributeValidatorFactory = $attributeValidatorFactory;
        $this->conditionBuilderFactory = $conditionBuilderFactory;
        $this->builderMap = $builderMap ?? [];
        $this->attributeParser = $attributeParser;
    }

    /** {@inheritdoc} */
    public function build(FieldInterface $field, string $attribute, $value)
    {
        if (isset($this->builderMap[get_class($field)])) {
            $builderClassName = $this->builderMap[get_class($field)];
            $builder = $this->conditionBuilderFactory->build($builderClassName);

            return $builder->build($field, $attribute, $value);
        }

        [$operator, $attributeName] = $this->attributeParser->__invoke($field, $attribute);
        if ($field instanceof FieldConditionBuilderInterface) {
            return $field->buildCondition($operator, $attributeName, $value);
        }

        if ($field instanceof BuilderAwareFieldInterface && $field->getBuilderClass() !== null) {
            return $this->conditionBuilderFactory
                ->build($field->getBuilderClass())
                ->build($field, $attribute, $value);
        }

        if ($field instanceof SQLFieldInterface) {
            if (is_iterable($value)) {
                /** @psalm-suppress InvalidArrayOffset */
                return [$field->getSql() => $this->ensureConditionValueIsValid($field, 'in', $value)];
            }

            if ($value === null) {
                /** @psalm-suppress InvalidArrayOffset */
                return [$field->getSql() => null];
            }

            $operatorMap = [
                'eq' => '=',
                'ne' => '!=',
                'gt' => '>',
                'lt' => '<',
                'gte' => '>=',
                'lte' => '<=',
            ];

            return [
                $operatorMap[$operator] ?? $operator,
                $field->getSql(),
                $this->ensureConditionValueIsValid($field, $operator, $value),
            ];
        }

        throw new \BadMethodCallException(sprintf('The passed field %s can not be built', $field->getName()));
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     */
    public function canApply(FieldInterface $field, string $attribute, $value): bool
    {
        if (isset($this->builderMap[get_class($field)])) {
            $builderClassName = $this->builderMap[get_class($field)];
            $builder = $this->conditionBuilderFactory->build($builderClassName);

            $canApply = $builder->canApply($field, $attribute, $value);
            if ($canApply !== null) {
                return $canApply;
            }
        }

        if ($field instanceof BuilderAwareFieldInterface && $field->getBuilderClass() !== null) {
            /** @psalm-suppress NullableReturnStatement */
            return $this->conditionBuilderFactory
                ->build($field->getBuilderClass())
                ->canApply($field, $attribute, $value);
        }

        [, $attributeName] = $this->attributeParser->__invoke($field, $attribute);

        return $attributeName === $field->getName();
    }

    /**
     * @param mixed $value
     * @throws AttributeValidationException
     * @return mixed normalized $value
     */
    private function ensureConditionValueIsValid(FieldInterface $field, string $operator, $value)
    {
        if (!$field instanceof AttributedFieldInterface) {
            return $value;
        }

        $validator = $this->getAttributeOperatorValidator($field->getAttribute(), $operator);
        $value = $validator->normalize($value);
        $validator->ensureIsValid($value);

        return $value;
    }

    private function getAttributeOperatorValidator(AttributeInterface $attribute, string $operator): AttributeValidator
    {
        $rule = $attribute->getRuleForOperator($operator);

        return $this->attributeValidatorFactory->createByDefinition($rule);
    }
}
