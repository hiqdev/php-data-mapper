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

use DateTime;
use DateTimeImmutable;

/**
 * Class PlanHydrator.
 *
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class DateTimeImmutableHydrator extends GeneratedHydrator
{
    /**
     * {@inheritdoc}
     * @param object|DateTimeImmutable $object
     */
    public function hydrate(array $data, $object)
    {
        return new DateTimeImmutable(reset($data));
    }

    /**
     * {@inheritdoc}
     * @param object|DateTimeImmutable $object
     */
    public function extract($object)
    {
        return $object->format(DateTime::ATOM);
    }
}
