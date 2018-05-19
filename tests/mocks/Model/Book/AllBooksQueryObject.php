<?php declare(strict_types = 1);

namespace Tests\Mocks\Model\Book;

use Contributte\Nextras\Orm\QueryObject\QueryObject;
use Nextras\Dbal\QueryBuilder\QueryBuilder;

final class AllBooksQueryObject extends QueryObject
{

	public function doQuery(QueryBuilder $builder): QueryBuilder
	{
		return $builder->select('[*]')->from('[book]', 'b');
	}

}
