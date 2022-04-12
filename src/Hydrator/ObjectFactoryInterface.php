<?php

declare(strict_types=1);

namespace hiqdev\DataMapper\Hydrator;

interface ObjectFactoryInterface
{
    /**
     * @param class-string $className
     * @param array $data
     * @return object
     */
    public function createEmptyInstance(string $className, array $data = []): object;
}
