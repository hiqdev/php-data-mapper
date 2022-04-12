<?php

declare(strict_types=1);

/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Hydrator;

use Laminas\Hydrator\HydratorInterface;

/**
 * Trait GeneratedHydratorTrait
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
trait GeneratedHydratorTrait
{
    protected ?GeneratedHydratorFactory $generatedHydratorFactory = null;

    public function setGeneratedHydratorFactory(GeneratedHydratorFactory $generatedHydratorFactory): void
    {
        $this->generatedHydratorFactory = $generatedHydratorFactory;
    }

    /**
     * @param object|class-string $object
     */
    protected function getGeneratedHydrator($object): HydratorInterface
    {
        $this->generatedHydratorFactory ??= new GeneratedHydratorFactory();

        return $this->generatedHydratorFactory->getHydrator($object);
    }

    /**
     * @param array|object $data
     * @param string|object $object
     * @return object
     *
     * @psalm-param class-string<T>|T $object
     * @psalm-return T
     * @template T of object
     */
    public function hydrateChild($data, $object)
    {
        if (is_object($data)) {
            return $data;
        }

        return $this->hydrator->hydrate(is_array($data) ? $data : (array)$data, $object);
    }

    /**
     * @param object $object
     * @return mixed
     */
    public function extractChild($object)
    {
        return $object ? $this->hydrator->extract($object) : null;
    }

    /** {@inheritdoc} */
    public function hydrate(array $data, $object)
    {
        return $this->getGeneratedHydrator($object)->hydrate($data, $object);
    }
}
