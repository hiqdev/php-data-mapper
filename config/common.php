<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

$components = [
    'entityManager' => [
        '__class' => \hiqdev\DataMapper\Repository\EntityManager::class,
    ],
];

$singletons = [
    \hiqdev\DataMapper\Query\Field\FieldFactoryInterface::class => \hiqdev\DataMapper\Query\Field\FieldFactory::class,
    \hiqdev\DataMapper\Repository\ConnectionInterface::class => function ($container) {
        return class_exists('Yii') ? \Yii::$app->get('db') : $container->get('db');
    },
    \hiqdev\DataMapper\Repository\EntityManagerInterface::class => [
        '__class' => \hiqdev\DataMapper\Repository\EntityManager::class,
        'repositories' => [
        ],
    ],
    \Zend\Hydrator\HydratorInterface::class => \hiqdev\DataMapper\Hydrator\ConfigurableHydrator::class,
    \Laminas\Hydrator\HydratorInterface::class => \hiqdev\DataMapper\Hydrator\ConfigurableHydrator::class,
    \hiqdev\DataMapper\Hydrator\ConfigurableHydrator::class => [
        'hydrators' => [
            \DateTimeImmutable::class => \hiqdev\DataMapper\Hydrator\DateTimeImmutableHydrator::class,
         ],
    ],
    \hiqdev\DataMapper\Validator\AttributeValidatorFactoryInterface::class => \hiqdev\DataMapper\Validator\AttributeValidatorFactory::class,
    \hiqdev\DataMapper\Query\Builder\QueryConditionBuilderInterface::class => \hiqdev\DataMapper\Query\Builder\QueryConditionBuilder::class,
    \hiqdev\DataMapper\Query\Builder\QueryConditionBuilderFactoryInterface::class => \hiqdev\DataMapper\Query\Builder\QueryConditionBuilderFactory::class,
];

return class_exists(Yiisoft\Factory\Definitions\Reference::class)
    ? array_merge($components, $singletons)
    : ['components' => $components, 'container' => ['singletons' => $singletons]];
