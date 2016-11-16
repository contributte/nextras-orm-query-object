<?php

namespace Minetro\Nextras\Orm\QueryObject;

use Nextras\Dbal\Connection;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Dbal\Result\Result;

abstract class QueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public abstract function doQuery(QueryBuilder $builder);

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    protected function postQuery(QueryBuilder $builder)
    {
        return $builder;
    }

    /**
     * @param Result $result
     * @return Result
     */
    protected function postResult(Result $result)
    {
        return $result;
    }

    /**
     * @param Connection $connection
     * @return Result
     */
    public function fetch(Connection $connection)
    {
        // Build query
        $qb = $this->doQuery($connection->createQueryBuilder());

        // Decorate query
        $qb = $this->postQuery($qb);

        // Execute query
        $result = $connection->queryArgs(
            $qb->getQuerySql(),
            $qb->getQueryParameters()
        );

        // Decorate result
        $result = $this->postResult($result);

        return $result;
    }

}