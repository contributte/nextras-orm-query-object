<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidHydrationModeException;
use Contributte\Nextras\Orm\QueryObject\Queryable;
use Contributte\Nextras\Orm\QueryObject\Repository\TRepositoryQueryable;
use Nextras\Dbal\Connection;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Mapper\Mapper;
use Tester\Assert;
use Tests\Mocks\SimpleQueryObject;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test class that uses TRepositoryQueryable trait
 */
class TestRepository
{

	use TRepositoryQueryable;

	/** @var Mapper */
	public $mapper;

}

// Test: TRepositoryQueryable injectConnection stores connection
test(function (): void {
	$connection = Mockery::mock(Connection::class);

	$repo = new TestRepository();
	$repo->injectConnection($connection);

	// Using reflection to verify connection was stored
	$reflection = new ReflectionClass($repo);
	$property = $reflection->getProperty('connection');
	$property->setAccessible(true);

	Assert::same($connection, $property->getValue($repo));

	Mockery::close();
});

// Test: TRepositoryQueryable fetch with HYDRATION_RESULTSET returns Result
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

	$repo = new TestRepository();
	$repo->injectConnection($connection);

	$queryObject = new SimpleQueryObject();
	$fetchResult = $repo->fetch($queryObject, Queryable::HYDRATION_RESULTSET);

	Assert::type(Result::class, $fetchResult);

	Mockery::close();
});

// Test: TRepositoryQueryable fetch with HYDRATION_ENTITY returns ICollection
test(function (): void {
	$connection = Mockery::mock(Connection::class);
	$queryBuilder = Mockery::mock(QueryBuilder::class);
	$mapper = Mockery::mock(Mapper::class);

	// Suppress deprecation warnings from ICollection (PHP 8.4 issue with implicit nullable params)
	$previousErrorReporting = error_reporting();
	error_reporting($previousErrorReporting & ~E_DEPRECATED);
	$collection = Mockery::mock(ICollection::class);
	error_reporting($previousErrorReporting);

	$queryBuilder->shouldReceive('select')
		->with('[*]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('from')
		->with('[foobar]')
		->once()
		->andReturnSelf();

	$connection->shouldReceive('createQueryBuilder')
		->once()
		->andReturn($queryBuilder);

	$mapper->shouldReceive('toCollection')
		->with($queryBuilder)
		->once()
		->andReturn($collection);

	$repo = new TestRepository();
	$repo->injectConnection($connection);
	$repo->mapper = $mapper;

	$queryObject = new SimpleQueryObject();
	$fetchResult = $repo->fetch($queryObject, Queryable::HYDRATION_ENTITY);

	Assert::type(ICollection::class, $fetchResult);

	Mockery::close();
});

// Test: TRepositoryQueryable fetch throws InvalidHydrationModeException for invalid mode
test(function (): void {
	$connection = Mockery::mock(Connection::class);
	$queryBuilder = Mockery::mock(QueryBuilder::class);

	$queryBuilder->shouldReceive('select')
		->with('[*]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('from')
		->with('[foobar]')
		->once()
		->andReturnSelf();

	$connection->shouldReceive('createQueryBuilder')
		->once()
		->andReturn($queryBuilder);

	$repo = new TestRepository();
	$repo->injectConnection($connection);

	$queryObject = new SimpleQueryObject();

	Assert::exception(function () use ($repo, $queryObject): void {
		$repo->fetch($queryObject, 999);
	}, InvalidHydrationModeException::class, 'Invalid hydration mode "999"');

	Mockery::close();
});
