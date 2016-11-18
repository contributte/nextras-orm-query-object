<?php

namespace Minetro\Nextras\Orm\QueryObject;

use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;

abstract class ExecutableQueryObject extends QueryObject
{

    /** @var Connection */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Result $result
     * @return Result
     */
    public function postResult(Result $result)
    {
        return $result;
    }

    /**
     * @return Result
     */
    public function execute()
    {
        $qb = $this->fetch($this->connection->createQueryBuilder());

        // Execute query
        $result = $this->connection->queryArgs(
            $qb->getQuerySql(),
            $qb->getQueryParameters()
        );

        // Decorate result
        $result = $this->postResult($result);

        return $result;
    }

}
