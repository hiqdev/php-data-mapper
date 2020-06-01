<?php
/**
 * Data Mapper
 *
 * @link      https://github.com/hiqdev/php-data-mapper
 * @package   php-data-mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2020, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\DataMapper\Query;

/**
 * Class FilterField represents a field that can not be selected, but can
 * be used for filtering.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class FilterField extends Field
{
    /**
     * {@inheritdoc}
     */
    public function canBeSelected(): bool
    {
        return false;
    }
}
