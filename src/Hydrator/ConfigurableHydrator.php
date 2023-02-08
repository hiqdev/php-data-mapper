<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Hydrator;

use AllowDynamicProperties;
use Laminas\Hydrator\ExtractionInterface;
use Laminas\Hydrator\HydrationInterface;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ConfigurableHydrator is similar to Laminas DelegatingHydrator,
 * but stores a map of class and hydrator internally instead of using
 * DI for it.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
#[AllowDynamicProperties]
class ConfigurableHydrator implements HydratorInterface
{
    /**
     * @var array<class-string<object>, class-string<HydratorInterface>|HydratorInterface>
     */
    public array $hydrators = []; // TODO: make private after composer-config-plugin merging fix

    public function __construct(ContainerInterface $di, array $hydrators = [])
    {
        $this->di = $di;
        $this->hydrators = $hydrators;
    }

    /**
     * @param string $className
     * @throws NotConfiguredException
     * @return HydrationInterface|ExtractionInterface
     */
    protected function getHydrator($className)
    {
        $hydrator = $this->findHydrator($className);
        if ($hydrator === null) {
            throw new NotConfiguredException('Hydrator for "' . $className . '" is not configured');
        }
        if (empty($this->hydrators[$className])) {
            $this->hydrators[$className] = $hydrator;
        }
        if (!is_object($this->hydrators[$className])) {
            $this->hydrators[$className] = $this->di->get($this->hydrators[$className]);
            if ($this->hydrators[$className] instanceof HydratorAwareInterface) {
                $this->hydrators[$className]->setHydrator($this);
            }
        }

        return $this->hydrators[$className];
    }

    /**
     * @param class-string<object> $className
     * @return class-string<HydratorInterface>|HydrationInterface|null
     */
    private function findHydrator(string $className)
    {
        if (isset($this->hydrators[$className])) {
            return $this->hydrators[$className];
        }
        foreach ($this->hydrators as $entityClass => $hydrator) {
            if (is_a($className, $entityClass, true)) {
                return $hydrator;
            }
        }

        return null;
    }

    /**
     * Create new object of given class with the provided $data.
     * When given $data is object just returns it.
     * @param  object|array $data
     * @param  class-string $class class name
     * @return object
     */
    public function create($data, $class)
    {
        if (is_object($data)) {
            return $data;
        }

        return $this->hydrate(
            is_array($data) ? $data : [$data],
            $class
        );
    }

    /** {@inheritdoc} */
    public function hydrate(array $data, $object)
    {
        if (is_object($object)) {
            $hydrator = $this->getHydrator(get_class($object));
        } else {
            $hydrator = $this->getHydrator($object);
            if ($hydrator instanceof ObjectFactoryInterface) {
                $object = $hydrator->createEmptyInstance($object, $data);
            }
        }

        return $hydrator->hydrate($data, $object);
    }

    /**
     * Extract values from an object.
     *
     * @param  object $object
     * @return array
     */
    public function extract($object): array
    {
        return $this->getHydrator(get_class($object))->extract($object);
    }

    /**
     * Extract multiple objects.
     * @return array
     */
    public function extractAll(array $array, int $depth = 1)
    {
        --$depth;
        $res = [];
        foreach ($array as $key => $object) {
            $res[$key] = $depth>0 ? $this->extractAll($object, $depth) : $this->extract($object);
        }

        return $res;
    }
}
