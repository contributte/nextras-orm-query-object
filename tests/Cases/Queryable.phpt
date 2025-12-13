<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Queryable;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Test: Queryable interface defines HYDRATION_RESULTSET constant
test(function (): void {
	Assert::same(1, Queryable::HYDRATION_RESULTSET);
});

// Test: Queryable interface defines HYDRATION_ENTITY constant
test(function (): void {
	Assert::same(2, Queryable::HYDRATION_ENTITY);
});
