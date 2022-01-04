<?php declare(strict_types = 1);

namespace Tests\Mocks\Model\Book;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\ManyHasOne;
use Tests\Mocks\Model\User\User;

/**
 * @property int                $id     {primary}
 * @property string             $name
 * @property User|ManyHasOne    $author {m:1 User::$books}
 */
final class Book extends Entity
{

}
