<?php

namespace Minetro\Nextras\Orm\QueryObject;

use Nextras\Dbal\Result\Result;

interface QueryObjectManager
{

    /**
     * @param string $class
     * @return QueryObject
     */
    public function create($class);

    /**
     * @param QueryObject $queryObject
     * @return Result
     */
    public function fetch(QueryObject $queryObject);

}
