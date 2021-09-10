<?php

declare(strict_types=1);

namespace hiqdev\DataMapper\Query\Builder;

use hiqdev\DataMapper\Query\Field\FieldInterface;

interface AttributeParserInterface
{
    /**
     * @param FieldInterface $field
     * @param string $key
     *
     * @return array an array of two items: the comparison operator and the attribute name
     * @psalm-return array{0: string, 1: string} an array of two items: the comparison operator and the attribute name
     */
    public function __invoke(FieldInterface $field, string $key): array;
}
