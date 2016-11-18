<?php

namespace Tests\Mocks\Model\Book;

use Minetro\Nextras\Orm\QueryObject\ExecutableQueryObject;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class AllBooksExecutableQueryObject extends ExecutableQueryObject
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
