<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\QueryObject;

use Nextras\Dbal\QueryBuilder\QueryBuilder;

abstract class QueryObject implements Queryable
{

	public function fetch(QueryBuilder $builder): QueryBuilder
	{
		// Build query
		$qb = $this->doQuery($builder);

		// Decorate query
		$qb = $this->postQuery($qb);

		return $qb;
	}

	protected function postQuery(QueryBuilder $builder): QueryBuilder
	{
		return $builder;
	}

}
