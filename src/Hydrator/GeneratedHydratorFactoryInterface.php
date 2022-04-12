<?php
declare(strict_types=1);

namespace hiqdev\DataMapper\Hydrator;

use Laminas\Hydrator\HydratorInterface;

interface GeneratedHydratorFactoryInterface
{
    /**
     * @param class-string|object $classNameOrObject
     * @return HydratorInterface
     */
    public function getHydrator($classNameOrObject): HydratorInterface;
}
