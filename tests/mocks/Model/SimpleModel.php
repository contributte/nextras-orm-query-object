<?php

namespace Tests\Mocks\Model;

use Nextras\Orm\Model\Model;
use Tests\Mocks\Model\Book\BookRepository;
use Tests\Mocks\Model\User\UserRepository;

/**
 * @property-read UserRepository $users
 * @property-read BookRepository $books
 */
final class SimpleModel extends Model
{

}
