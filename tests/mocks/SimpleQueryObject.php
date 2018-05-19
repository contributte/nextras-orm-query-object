<?php declare(strict_types = 1);

namespace Tests\Mocks;

use Contributte\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class SimpleQueryObject extends QueryObject
{

	public function doQuery(QueryBuilder $builder): QueryBuilder
	{
		return $builder->select('[*]')->from('[foobar]');
	}

}
