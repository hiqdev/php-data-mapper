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

use yii\db\Query;

class QueryMutator
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @param Query $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function apply(Specification $specification)
    {
        if ($specification->where) {
            $this->query->andWhere($specification->where);
        }

        if ($specification->limit) {
            $this->query->limit($specification->limit);
        }

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
