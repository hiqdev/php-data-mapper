<?php declare(strict_types=1);

namespace hiqdev\DataMapper\Events;

class EntitiesSavedEvent
{
    private array $entities;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    public function getEntities(): array
    {
        return $this->entities;
    }
}
