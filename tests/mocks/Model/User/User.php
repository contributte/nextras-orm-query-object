<?php

namespace Tests\Mocks\Model\User;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;
use Tests\Mocks\Model\Book\Book;

/**
 * @property int                $id     {primary}
 * @property string             $name
 * @property Book[]|OneHasMany  $books  {1:m Book::$author}
 */
final class User extends Entity
{

}
