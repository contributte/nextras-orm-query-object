<?php

namespace Tests\Mocks\Model\User;

use Minetro\Nextras\Orm\QueryObject\Repository\TRepositoryQueryable;
use Nextras\Orm\Repository\Repository;

final class UserRepository extends Repository
{

    use TRepositoryQueryable;

    /**
     * @return array
     */
    public static function getEntityClassNames()
    {
        return [User::class];
    }

}
