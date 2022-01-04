<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject;

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidObjectCreationException;
use Nette\DI\Container;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Result\Result;

class QueryObjectContextAwareManager implements QueryObjectManager
{

	/** @var Container */
	protected $context;

	public function __construct(Container $context)
	{
		$this->context = $context;
	}

	public function fetch(QueryObject $queryObject): Result
	{
		/** @var Connection $connection */
		$connection = $this->context->getByType(Connection::class);

		$qb = $queryObject->fetch($connection->createQueryBuilder());

		$result = $connection->queryArgs(
			$qb->getQuerySql(),
			$qb->getQueryParameters()
		);

		if ($queryObject instanceof ExecutableQueryObject) {
			$result = $queryObject->postResult($result);
		}

		return $result;
	}

	/**
	 * @param class-string $class
	 */
	public function create(string $class): QueryObject
	{
		$obj = $this->context->getByType($class);

		if (!($obj instanceof QueryObject)) {
			throw new InvalidObjectCreationException(sprintf('Created object must be typed of %s, type of %s given.', QueryObject::class, get_class($obj)));
		}

		return $obj;
	}

}
