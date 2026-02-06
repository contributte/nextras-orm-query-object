<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension;
use Contributte\Nextras\Orm\QueryObject\QueryObjectManager;
use Contributte\Tester\Environment;
use Contributte\Tester\Toolkit;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(static function (): void {
	$loader = new ContainerLoader(Environment::getTestDir());
	$class = $loader->load(static function (Compiler $compiler): void {
		$compiler->addExtension('nextrasqueryobject', new NextrasQueryObjectExtension());
	}, microtime());

	/** @var Container $container */
	$container = new $class();

	Assert::type(QueryObjectManager::class, $container->getByType(QueryObjectManager::class));
});
