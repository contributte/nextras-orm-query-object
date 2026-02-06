<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidHydrationModeException;
use Contributte\Nextras\Orm\QueryObject\Exception\InvalidObjectCreationException;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Test: InvalidHydrationModeException extends LogicException
Toolkit::test(static function (): void {
	$exception = new InvalidHydrationModeException('Test message');

	Assert::type(LogicException::class, $exception);
	Assert::same('Test message', $exception->getMessage());
});

// Test: InvalidObjectCreationException extends LogicException
Toolkit::test(static function (): void {
	$exception = new InvalidObjectCreationException('Creation failed');

	Assert::type(LogicException::class, $exception);
	Assert::same('Creation failed', $exception->getMessage());
});

// Test: InvalidHydrationModeException can be thrown and caught
Toolkit::test(static function (): void {
	Assert::exception(static function (): void {
		throw new InvalidHydrationModeException('Invalid hydration mode "99"');
	}, InvalidHydrationModeException::class, 'Invalid hydration mode "99"');
});

// Test: InvalidObjectCreationException can be thrown and caught
Toolkit::test(static function (): void {
	Assert::exception(static function (): void {
		throw new InvalidObjectCreationException('Created object must be typed of QueryObject');
	}, InvalidObjectCreationException::class, 'Created object must be typed of QueryObject');
});
