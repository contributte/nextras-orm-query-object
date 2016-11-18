<?php

namespace Tests\Mocks;

use Minetro\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleQueryObject extends QueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->select('[*]')->from('[foobar]');
    }

}
