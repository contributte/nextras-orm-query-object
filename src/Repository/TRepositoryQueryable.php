<?php

namespace Minetro\Nextras\Orm\QueryObject\Repository;

use Minetro\Nextras\Orm\QueryObject\Exception\InvalidHydrationModeException;
use Minetro\Nextras\Orm\QueryObject\ExecutableQueryObject;
use Minetro\Nextras\Orm\QueryObject\Queryable;
use Minetro\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;
use Nextras\Orm\Entity\IEntity;

trait TRepositoryQueryable
{

    /** @var Connection */
    protected $connection;

    /**
     * @param Connection $connection
     * @return void
     */
    public function injectConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param QueryObject $queryObject
     * @param int $hydrationMode
     * @return Result|IEntity
     */
    public function fetch(QueryObject $queryObject, $hydrationMode = Queryable::HYDRATION_RESULTSET)
    {
        $qb = $queryObject->fetch($this->connection->createQueryBuilder());

        if ($hydrationMode === Queryable::HYDRATION_RESULTSET) {
            $result = $this->connection->queryArgs(
                $qb->getQuerySql(),
                $qb->getQueryParameters()
            );

            if ($queryObject instanceof ExecutableQueryObject) {
                $result = $queryObject->postResult($result);
            }

            return $result;
        } else if ($hydrationMode === Queryable::HYDRATION_ENTITY) {
            return $this->mapper->toCollection($qb);
        } else {
            throw new InvalidHydrationModeException(sprintf('Invalid hydration mode "%s"', $hydrationMode));
        }
    }

}
