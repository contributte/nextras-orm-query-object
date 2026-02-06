<?php declare(strict_types = 1);

namespace Tests\Mocks;

use Nextras\Dbal\Connection;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleConnection extends Connection
{

	public function createQueryBuilder(): QueryBuilder
	{
		return new QueryBuilder($this->getPlatform());
	}

}
