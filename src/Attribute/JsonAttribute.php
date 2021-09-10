<?php
declare(strict_types=1);

namespace hiqdev\DataMapper\Attribute;

class JsonAttribute extends AbstractAttribute
{
    public function getOperatorRules()
    {
        return [
            'eq' => ['string'],
            'has' => ['string'],
        ];
    }
}
