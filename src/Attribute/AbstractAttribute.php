<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\attributes;

abstract class AbstractAttribute implements AttributeInterface
{
    abstract protected function getOperatorRules();

    public function getRuleForOperator(string $operator): array
    {
        $aliases = [
            '' => 'eq',
        ];

        $operator = $aliases[$operator] ?? $operator;
        $rules = $this->getOperatorRules();
        if (isset($rules[$operator])) {
            return $rules[$operator];
        }

        throw UnsupportedOperatorException::forOperator($operator);
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedOperators(): array
    {
        return array_keys($this->getOperatorRules());
    }
}
