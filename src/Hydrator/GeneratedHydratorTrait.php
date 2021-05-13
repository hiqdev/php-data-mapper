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

use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

trait GeneratedHydratorTrait
{
    /**
     * @var HydratorInterface[]
     */
    protected $generatedHydrators = [];

    /**
     * @param object $object
     */
    protected function getGeneratedHydrator($object): HydratorInterface
    {
        $class = get_class($object);
        if (empty($this->generatedHydrators[$class])) {
            $config = new Configuration($class);
            spl_autoload_register($config->getGeneratedClassAutoloader());
            $hydratorClass = $config->createFactory()->getHydratorClass();

            $this->generatedHydrators[$class] = new $hydratorClass();
        }

        return $this->generatedHydrators[$class];
    }

    /**
     * @param array|object $data
     * @param string|object $object
     * @return object
     */
    public function hydrateChild($data, $object)
    {
        return is_object($data) ? $data : $this->hydrator->hydrate(is_array($data) ? $data : (array)$data, $object);
    }

    public function hydrate(array $data, $object)
    {
        return $this->getGeneratedHydrator($object)->hydrate($data, $object);
    }

    /**
     * @param ?object $object
     * @return ?array
     */
    public function extractChild($object)
    {
        return $object ? $this->hydrator->extract($object) : null;
    }

    /**
     * @throws \ReflectionException
     * @return object
     */
    public function createEmptyInstance(string $className, array $data = [])
    {
        $reflection = new \ReflectionClass($className);

        return $reflection->newInstanceWithoutConstructor();
    }
}
