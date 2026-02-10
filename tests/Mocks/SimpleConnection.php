<?php declare(strict_types = 1);

namespace Tests\Mocks;

use Mockery;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Platforms\IPlatform;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleConnection extends Connection
{

	public function createQueryBuilder(): QueryBuilder
	{
		$platform = Mockery::mock(IPlatform::class);

		return new QueryBuilder($platform);
	}

}
