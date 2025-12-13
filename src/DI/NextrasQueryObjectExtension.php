<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject\DI;

use Contributte\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Contributte\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\CompilerExtension;
use Nette\DI\Extensions\InjectExtension;
use Nextras\Orm\Mapper\Mapper;
use Nextras\Orm\Repository\Repository;

final class NextrasQueryObjectExtension extends CompilerExtension
{

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('manager'))
			->setType(QueryObjectManager::class)
			->setFactory(QueryObjectContextAwareManager::class);
	}

	/**
	 * Decorate services
	 */
	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		foreach ($builder->findByType(Repository::class) as $name => $def) {
			$def->addTag(InjectExtension::TagInject);
		}

		foreach ($builder->findByType(Mapper::class) as $name => $def) {
			$def->addTag(InjectExtension::TagInject);
		}
	}

}
