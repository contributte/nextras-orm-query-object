<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Nextras\Dbal\Platforms\IPlatform;
use Nextras\Dbal\QueryBuilder\QueryBuilder;
use Tester\Assert;
use Tests\Mocks\SimpleQueryObject;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(static function (): void {
	$platform = Mockery::mock(IPlatform::class);
	$qo = new SimpleQueryObject();
	$qb = $qo->fetch(new QueryBuilder($platform));

	Assert::type(QueryBuilder::class, $qb);
	Assert::equal('SELECT * FROM [foobar]', $qb->getQuerySql());

	Mockery::close();
});
