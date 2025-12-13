<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidObjectCreationException;
use Contributte\Nextras\Orm\QueryObject\QueryObject;
use Contributte\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Nette\DI\Container;
use Nextras\Dbal\Connection;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Dbal\Result\Result;
use Tester\Assert;
use Tests\Mocks\SimpleQueryObject;

require_once __DIR__ . '/../bootstrap.php';

// Test: QueryObjectContextAwareManager create returns QueryObject
test(function (): void {
	$queryObject = new SimpleQueryObject();

	$container = Mockery::mock(Container::class);
	$container->shouldReceive('getByType')
		->with(SimpleQueryObject::class)
		->once()
		->andReturn($queryObject);

	$manager = new QueryObjectContextAwareManager($container);
	$result = $manager->create(SimpleQueryObject::class);

	Assert::type(QueryObject::class, $result);
	Assert::same($queryObject, $result);

	Mockery::close();
});

// Test: QueryObjectContextAwareManager create throws InvalidObjectCreationException for non-QueryObject
test(function (): void {
	$nonQueryObject = new stdClass();

	$container = Mockery::mock(Container::class);
	$container->shouldReceive('getByType')
		->with(stdClass::class)
		->once()
		->andReturn($nonQueryObject);

	$manager = new QueryObjectContextAwareManager($container);

	Assert::exception(function () use ($manager): void {
		$manager->create(stdClass::class);
	}, InvalidObjectCreationException::class);

	Mockery::close();
});

// Test: QueryObjectContextAwareManager fetch returns Result
test(function (): void {
	$connection = Mockery::mock(Connection::class);
	$queryBuilder = Mockery::mock(QueryBuilder::class);
	$result = Mockery::mock(Result::class);

	$queryBuilder->shouldReceive('select')
		->with('[*]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('from')
		->with('[foobar]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('getQuerySql')
		->once()
		->andReturn('SELECT * FROM foobar');

	$queryBuilder->shouldReceive('getQueryParameters')
		->once()
		->andReturn([]);

	$connection->shouldReceive('createQueryBuilder')
		->once()
		->andReturn($queryBuilder);

	$connection->shouldReceive('queryArgs')
		->with('SELECT * FROM foobar', [])
		->once()
		->andReturn($result);

	$container = Mockery::mock(Container::class);
	$container->shouldReceive('getByType')
		->with(Connection::class)
		->once()
		->andReturn($connection);

	$manager = new QueryObjectContextAwareManager($container);
	$queryObject = new SimpleQueryObject();
	$fetchResult = $manager->fetch($queryObject);

	Assert::type(Result::class, $fetchResult);

	Mockery::close();
});
