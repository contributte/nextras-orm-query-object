<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject;

use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;

abstract class ExecutableQueryObject extends QueryObject
{

	/** @var Connection */
	protected $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function postResult(Result $result): Result
	{
		return $result;
	}

	public function execute(): Result
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
