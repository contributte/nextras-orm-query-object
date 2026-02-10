<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Queryable;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test('Queryable interface defines HYDRATION_RESULTSET constant', function (): void {
	Assert::same(1, Queryable::HYDRATION_RESULTSET);
});

test('Queryable interface defines HYDRATION_ENTITY constant', function (): void {
	Assert::same(2, Queryable::HYDRATION_ENTITY);
});
