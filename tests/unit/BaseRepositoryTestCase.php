<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\tests\unit;

use hiqdev\DataMapper\Repository\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use yii\helpers\Yii;

abstract class BaseRepositoryTestCase extends TestCase
{
    protected function getRepository(string $entityClass)
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->getContainer()->get(EntityManagerInterface::class);
    }

    protected function getContainer()
    {
        return class_exists('Yii') ? \Yii::$container : Yii::getContainer();
    }
}
