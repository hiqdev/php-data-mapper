<?php

declare(strict_types=1);

namespace hiqdev\DataMapper\Query\Builder;

use hiqdev\DataMapper\Query\Field\AttributedFieldInterface;
use hiqdev\DataMapper\Query\Field\FieldInterface;

class AttributeParser implements AttributeParserInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(FieldInterface $field, string $key): array
    {
        if (!$field instanceof AttributedFieldInterface
            || $field->getName() === $key
        ) {
            return ['eq', $key];
        }

        /*
         * Extracts underscore suffix from the key.
         *
         * Examples:
         * client_id -> 0 - client_id, 1 - client, 2 - _id, 3 - id
         * server_owner_like -> 0 - server_owner_like, 1 - server_owner, 2 - _like, 3 - like
         */
        preg_match('/^(.*?)(_((?:.(?!_))+))?$/', $key, $matches);

        $operator = 'eq';

        // If the suffix is in the list of acceptable suffix filer conditions
        if (isset($matches[3]) && in_array($matches[3], $field->getAttribute()->getSupportedOperators(), true)) {
            $operator = $matches[3];
            $key = $matches[1];
        }

        return [$operator, $key];
    }
}
