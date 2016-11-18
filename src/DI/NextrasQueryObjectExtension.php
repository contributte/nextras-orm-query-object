<?php

namespace Minetro\Nextras\Orm\QueryObject\DI;

use Minetro\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Minetro\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\CompilerExtension;
use Nextras\Orm\Mapper\Mapper;
use Nextras\Orm\Repository\Repository;

final class NextrasQueryObjectExtension extends CompilerExtension
{

    /**
     * Register services
     *
     * @return void
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('manager'))
            ->setClass(QueryObjectManager::class)
            ->setFactory(QueryObjectContextAwareManager::class);
    }

    /**
     * Decorate services
     *
     * @return void
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        foreach ($builder->findByType(Repository::class) as $name => $def) {
            $def->setInject(TRUE);
        }

        foreach ($builder->findByType(Mapper::class) as $name => $def) {
            $def->setInject(TRUE);
        }
    }

}
