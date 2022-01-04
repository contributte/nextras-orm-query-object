<?php declare(strict_types = 1);

namespace Tests\Mocks\Model\Book;

use Contributte\Nextras\Orm\QueryObject\Repository\TRepositoryQueryable;
use Nextras\Orm\Repository\Repository;

final class BookRepository extends Repository
{

	use TRepositoryQueryable;

	/**
	 * @return string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [Book::class];
	}

}
