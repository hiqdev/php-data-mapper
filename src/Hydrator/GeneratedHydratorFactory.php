<?php
declare(strict_types=1);

namespace hiqdev\DataMapper\Hydrator;

use GeneratedHydrator\Configuration;
use Laminas\Hydrator\HydratorInterface;

class GeneratedHydratorFactory implements GeneratedHydratorFactoryInterface
{
    protected array $generatedHydrators = [];

    public function getHydrator($classNameOrObject): HydratorInterface
    {
        $class = is_object($classNameOrObject) ? get_class($classNameOrObject) : $classNameOrObject;

        if (empty($this->generatedHydrators[$class])) {
            $config = $this->getConfiguration($class);
            $hydratorClass = $config->createFactory()->getHydratorClass();

            $this->generatedHydrators[$class] = new $hydratorClass();
        }

        return $this->generatedHydrators[$class];

    }

    private function getConfiguration(string $className): Configuration
    {
        $config = new Configuration($className);
        spl_autoload_register($config->getGeneratedClassAutoloader());

        return $config;
    }
}
