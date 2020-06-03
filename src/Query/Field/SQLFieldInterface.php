<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query\Field;

use yii\db\ExpressionInterface;

interface SQLFieldInterface extends FieldInterface
{
    /**
     * Provides SQL statement that represents the selected field.
     * The statement can be used for both WHERE and SELECT statements
     *
     * @return string|ExpressionInterface
     */
    public function getSql();

    /**
     * Whether this field can be selected
     */
    public function canBeSelected(): bool;
}
