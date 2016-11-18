<?php

/**
 * @Test: [unit] Minetro\Nextras\Orm\QueryObject\QueryObject
 */

use Nextras\Dbal\Connection;
use Nextras\Dbal\Drivers\IResultAdapter;
use Nextras\Dbal\Drivers\Mysqli\MysqliDriver;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Dbal\Result\Result;
use Tester\Assert;
use Tests\Mocks\SimpleQueryObject;

require_once __DIR__ . '/../../bootstrap.php';

test(function () {
    $connection = Mockery::mock(Connection::class);
    $connection->shouldReceive('createQueryBuilder')
        ->andReturnUsing(function () {
            return new QueryBuilder(new MysqliDriver());
        });
    $connection->shouldReceive('queryArgs')
        ->andReturnUsing(function () {
            $adapter = Mockery::mock(IResultAdapter::class);
            $adapter->shouldReceive('getTypes')->andReturn([]);

            return new Result($adapter, new MysqliDriver(), 0);
        });

    $qo = new SimpleQueryObject();
    $result = $qo->fetch($connection);

    Assert::type(Result::class, $result);
});
