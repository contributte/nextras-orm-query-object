<?php

namespace Minetro\Nextras\Orm\QueryObject;

use Nextras\Dbal\QueryBuilder\QueryBuilder;

abstract class QueryObject implements Queryable
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    protected function postQuery(QueryBuilder $builder)
    {
        return $builder;
    }

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function fetch(QueryBuilder $builder)
    {
        // Build query
        $qb = $this->doQuery($builder);

        // Decorate query
        $qb = $this->postQuery($qb);

        return $qb;
    }

}
