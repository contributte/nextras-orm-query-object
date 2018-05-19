<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject\Repository;

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidHydrationModeException;
use Contributte\Nextras\Orm\QueryObject\ExecutableQueryObject;
use Contributte\Nextras\Orm\QueryObject\Queryable;
use Contributte\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;
use Nextras\Orm\Entity\IEntity;

trait TRepositoryQueryable
{

	/** @var Connection */
	protected $connection;

	public function injectConnection(Connection $connection): void
	{
		$this->connection = $connection;
	}

	/**
	 * @return Result|IEntity
	 */
	public function fetch(QueryObject $queryObject, int $hydrationMode = Queryable::HYDRATION_RESULTSET)
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
		} elseif ($hydrationMode === Queryable::HYDRATION_ENTITY) {
			return $this->mapper->toCollection($qb);
		} else {
			throw new InvalidHydrationModeException(sprintf('Invalid hydration mode "%s"', $hydrationMode));
		}
	}

}
