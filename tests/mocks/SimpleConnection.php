<?php

namespace Tests\Mocks;

use Mockery;
use Nextras\Dbal\Connection;
use Nextras\Dbal\Drivers\IDriver;
use Nextras\Dbal\Drivers\Mysqli\MysqliDriver;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleConnection extends Connection
{

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
    }

    /**
     * @return IDriver
     */
    public function getDriver()
    {
        $driver = Mockery::mock(MysqliDriver::class)->makePartial();
        $driver->shouldReceive('connect')->andReturn(TRUE);

        return $driver;
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return new QueryBuilder($this->getDriver());
    }

}
