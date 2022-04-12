<?php

declare(strict_types=1);

namespace hiqdev\DataMapper\Hydrator;

use Laminas\Hydrator\Strategy\HydratorStrategy;
use ReflectionClass;
use ReflectionException;

/**
 * Trait ObjectFactoryTrait
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @implements ObjectFactoryInterface
 *
 * @todo Probably, it should be somehow replaced with {@see HydratorStrategy}
 */
trait ObjectFactoryTrait
{
    /**
     * @param class-string $className
     * @param array $data
     * @return object
     * @throws ReflectionException
     */
    public function createEmptyInstance(string $className, array $data = []): object
    {
        $reflection = new ReflectionClass($className);

        return $reflection->newInstanceWithoutConstructor();
    }
}
