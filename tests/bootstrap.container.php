<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nette\DI\Extensions\DIExtension;
use Nette\DI\Extensions\InjectExtension;
use Nextras\Dbal\Bridges\NetteDI\DbalExtension;
use Nextras\Orm\Bridges\NetteDI\OrmExtension;
use Tester\FileMock;

require_once __DIR__ . '/bootstrap.php';

$loader = new ContainerLoader(TEMP_DIR);
$class = $loader->load(function (Compiler $compiler): void {
	$compiler->addExtension('inject', new InjectExtension());
	$compiler->addExtension('di', new DIExtension());
	$compiler->addExtension('dbal', new DbalExtension());
	$compiler->addExtension('orm', new OrmExtension());
	$compiler->addExtension('nextrasqueryobject', new NextrasQueryObjectExtension());
	$compiler->loadConfig(FileMock::create('
    dbal:
        driver: mysqli
        host: 127.0.0.1
        username: root
        password: ""
        database: nextras
   
    orm:
        model: Tests\Mocks\Model\SimpleModel
        
    services:
        - Nette\Caching\Storages\DevNullStorage
        - Nette\Caching\Cache
        - Tests\Mocks\Model\Book\AllBooksExecutableQueryObject
    ', 'neon'));
}, microtime());

/** @var Container $container */
$container = new $class();
$container->initialize();

return $container;
