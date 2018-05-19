<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject;

use Nextras\Dbal\Result\Result;

interface QueryObjectManager
{

	public function create(string $class): QueryObject;

	public function fetch(QueryObject $queryObject): Result;

}
