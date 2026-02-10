<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\Exception\InvalidHydrationModeException;
use Contributte\Nextras\Orm\QueryObject\Exception\InvalidObjectCreationException;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test('InvalidHydrationModeException extends LogicException', function (): void {
	$exception = new InvalidHydrationModeException('Test message');

	Assert::type(LogicException::class, $exception);
	Assert::same('Test message', $exception->getMessage());
});

test('InvalidObjectCreationException extends LogicException', function (): void {
	$exception = new InvalidObjectCreationException('Creation failed');

	Assert::type(LogicException::class, $exception);
	Assert::same('Creation failed', $exception->getMessage());
});

test('InvalidHydrationModeException can be thrown and caught', function (): void {
	Assert::exception(function (): void {
		throw new InvalidHydrationModeException('Invalid hydration mode "99"');
	}, InvalidHydrationModeException::class, 'Invalid hydration mode "99"');
});

test('InvalidObjectCreationException can be thrown and caught', function (): void {
	Assert::exception(function (): void {
		throw new InvalidObjectCreationException('Created object must be typed of QueryObject');
	}, InvalidObjectCreationException::class, 'Created object must be typed of QueryObject');
});
