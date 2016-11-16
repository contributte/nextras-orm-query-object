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
     * @return Result
     */
    public function execute()
    {
        return $this->fetch($this->connection);
    }

}