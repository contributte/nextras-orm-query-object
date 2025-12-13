<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\ExecutableQueryObject;
use Nextras\Dbal\Connection;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Nextras\Dbal\Result\Result;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test ExecutableQueryObject
 */
class TestExecutableQueryObject extends ExecutableQueryObject
{

	public function doQuery(QueryBuilder $builder): QueryBuilder
	{
		return $builder->select('[*]')->from('[test_table]');
	}

}

/**
 * Test ExecutableQueryObject with custom postResult
 */
class TestExecutableQueryObjectWithPostResult extends ExecutableQueryObject
{

	private bool $postResultCalled = false;

	public function doQuery(QueryBuilder $builder): QueryBuilder
	{
		return $builder->select('[id]')->from('[users]');
	}

	public function postResult(Result $result): Result
	{
		$this->postResultCalled = true;
		return parent::postResult($result);
	}

	public function wasPostResultCalled(): bool
	{
		return $this->postResultCalled;
	}

}

// Test: ExecutableQueryObject builds query via fetch method
test(function (): void {
	$connection = Mockery::mock(Connection::class);
	$queryBuilder = Mockery::mock(QueryBuilder::class);

	$queryBuilder->shouldReceive('select')
		->with('[*]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('from')
		->with('[test_table]')
		->once()
		->andReturnSelf();

	$qo = new TestExecutableQueryObject($connection);
	$result = $qo->fetch($queryBuilder);

	Assert::type(QueryBuilder::class, $result);

	Mockery::close();
});

// Test: ExecutableQueryObject execute method uses connection
test(function (): void {
	$connection = Mockery::mock(Connection::class);
	$queryBuilder = Mockery::mock(QueryBuilder::class);
	$result = Mockery::mock(Result::class);

	$queryBuilder->shouldReceive('select')
		->with('[*]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('from')
		->with('[test_table]')
		->once()
		->andReturnSelf();

	$queryBuilder->shouldReceive('getQuerySql')
		->once()
		->andReturn('SELECT * FROM test_table');

	$queryBuilder->shouldReceive('getQueryParameters')
		->once()
		->andReturn([]);

	$connection->shouldReceive('createQueryBuilder')
		->once()
		->andReturn($queryBuilder);

	$connection->shouldReceive('queryArgs')
		->with('SELECT * FROM test_table', [])
		->once()
		->andReturn($result);

	$qo = new TestExecutableQueryObject($connection);
	$executeResult = $qo->execute();

	Assert::type(Result::class, $executeResult);

	Mockery::close();
});
