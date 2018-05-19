<?php declare(strict_types = 1);

namespace Tests\Mocks\Model\User;

use Contributte\Nextras\Orm\QueryObject\Repository\TRepositoryQueryable;
use Nextras\Orm\Repository\Repository;

final class UserRepository extends Repository
{

	use TRepositoryQueryable;

	/**
	 * @return string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [User::class];
	}

}
