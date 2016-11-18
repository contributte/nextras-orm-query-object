<?php
namespace Minetro\Nextras\Orm\QueryObject;

use Nextras\Dbal\QueryBuilder\QueryBuilder;

interface Queryable
{

    // Hydration modes
    const HYDRATION_RESULTSET = 1;
    const HYDRATION_ENTITY = 2;

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder);

}
