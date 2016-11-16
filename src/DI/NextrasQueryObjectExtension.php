<?php

namespace Minetro\Nextras\Orm\QueryObject\DI;

use Minetro\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Minetro\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\CompilerExtension;

final class NextrasQueryObjectExtension extends CompilerExtension
{

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('manager'))
            ->setClass(QueryObjectManager::class)
            ->setFactory(QueryObjectContextAwareManager::class);
    }

}
