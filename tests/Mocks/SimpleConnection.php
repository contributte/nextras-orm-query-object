<?php declare(strict_types = 1);

namespace Tests\Mocks;

use Mockery;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Drivers\IDriver;
use Nextras\Dbal\Drivers\Mysqli\MysqliDriver;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleConnection extends Connection
{

	public function getDriver(): IDriver
	{
		$driver = Mockery::mock(MysqliDriver::class)->makePartial();
		$driver->shouldReceive('connect')->andReturn(true);

		return $driver;
	}

	public function createQueryBuilder(): QueryBuilder
	{
		return new QueryBuilder($this->getDriver());
	}

}
