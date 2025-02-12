<?php declare(strict_types=1);

namespace hiqdev\DataMapper\Events;

class EntitiesSavedEvent
{
    public array $entities;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }
}
