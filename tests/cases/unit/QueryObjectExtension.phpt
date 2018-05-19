<?php declare(strict_types = 1);

/**
 * @Test: [unit] Contributte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension
 */

use Contributte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension;
use Contributte\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->addExtension('nextrasqueryobject', new NextrasQueryObjectExtension());
	}, microtime());

	/** @var Container $container */
	$container = new $class();

	Assert::type(QueryObjectManager::class, $container->getByType(QueryObjectManager::class));
});
