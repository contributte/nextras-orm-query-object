<?php

namespace Minetro\Nextras\Orm\QueryObject\Repository;

use Minetro\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;

trait TRepositoryQueryable
{

    /** @var Connection */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function injectConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param QueryObject $queryObject
     * @return Result
     */
    public function fetch(QueryObject $queryObject)
    {
        return $queryObject->fetch($this->connection);
    }

}
