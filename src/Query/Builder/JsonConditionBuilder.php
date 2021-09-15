<?php
declare(strict_types=1);

namespace hiqdev\DataMapper\Query\Builder;

use hiqdev\DataMapper\Query\Field\FieldInterface;
use hiqdev\DataMapper\Query\Field\SQLFieldInterface;
use InvalidArgumentException;
use JsonException;
use yii\db\Expression;
use yii\db\JsonExpression;

class JsonConditionBuilder implements QueryConditionBuilderInterface
{
    private AttributeParserInterface $attributeParser;

    public function __construct(AttributeParserInterface $attributeParser)
    {
        $this->attributeParser = $attributeParser;
    }

    private function jsonDecode(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }

        try {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
    }

    public function build(FieldInterface $field, string $attribute, $value)
    {
        if (!$field instanceof SQLFieldInterface) {
            throw new InvalidArgumentException('JsonConditionBuilder supports only SQLFieldInterface fields');
        }

        // TODO: drop after QueryConditionBuilderInterface get changed
        [$operator, $key] = $this->attributeParser->__invoke($field, $attribute);

        $operatorMap = [
            'has' => '@>',
        ];

        return [
            $operatorMap[$operator] ?? '=',
            new Expression($field->getSql()),
            new JsonExpression($this->jsonDecode($value))
        ];
    }

    public function canApply(FieldInterface $field, string $attribute, $value): ?bool
    {
        [, $attribute] = $this->attributeParser->__invoke($field, $attribute);

        if ($attribute !== $field->getName()) {
            return false;
        }

        return $field instanceof SQLFieldInterface && $value !== null && $this->jsonDecode($value) !== null;
    }
}
