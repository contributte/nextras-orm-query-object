<?php

namespace Tests\Mocks\Model\Book;

use Minetro\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class AllBooksQueryObject extends QueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->select('[*]')->from('[book]', 'b');
    }

}
