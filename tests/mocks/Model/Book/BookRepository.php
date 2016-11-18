<?php

namespace Tests\Mocks\Model\Book;

use Minetro\Nextras\Orm\QueryObject\Repository\TRepositoryQueryable;
use Nextras\Orm\Repository\Repository;

final class BookRepository extends Repository
{

    use TRepositoryQueryable;

    /**
     * @return array
     */
    public static function getEntityClassNames()
    {
        return [Book::class];
    }

}
