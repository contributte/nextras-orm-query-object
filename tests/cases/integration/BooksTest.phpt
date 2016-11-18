<?php

namespace Tests\Cases\Integration;

/**
 * @Test: [integration] Books
 */

use Minetro\Nextras\Orm\QueryObject\Queryable;
use Minetro\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Minetro\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\Container;
use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Tester\Assert;
use Tester\TestCase;
use Tests\Mocks\Model\Book\AllBooksExecutableQueryObject;
use Tests\Mocks\Model\Book\AllBooksQueryObject;
use Tests\Mocks\Model\Book\Book;
use Tests\Mocks\Model\Book\BookRepository;
use Tests\Mocks\Model\User\User;

$container = require_once __DIR__ . '/../../bootstrap.container.php';

final class BooksTest extends TestCase
{

    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Test empty results
     *
     * @return void
     */
    public function testEmpty()
    {
        /** @var BookRepository $books */
        $books = $this->container->getByType(BookRepository::class);
        Assert::count(0, $books->findAll());

        $qo = new AllBooksQueryObject();
        $result = $books->fetch($qo, Queryable::HYDRATION_ENTITY);
        Assert::type(ICollection::class, $result);
        Assert::count(0, $result);

        $qo = new AllBooksQueryObject();
        $result = $books->fetch($qo, Queryable::HYDRATION_RESULTSET);
        Assert::type(Result::class, $result);
        Assert::count(0, $result->fetchAll());
    }

    /**
     * Test hydration of query object
     *
     * @return void
     */
    public function testHydration()
    {
        /** @var BookRepository $books */
        $books = $this->container->getByType(BookRepository::class);

        $author = new User();
        $author->name = 'foobar1';

        $book = new Book();
        $book->name = 'foobar2';
        $book->author = $author;

        $books->persistAndFlush($book);

        Assert::count(1, $books->findAll());

        $qo = new AllBooksQueryObject();
        $result = $books->fetch($qo, Queryable::HYDRATION_ENTITY);
        Assert::type(ICollection::class, $result);
        Assert::count(1, $result);

        $qo = new AllBooksQueryObject();
        $result = $books->fetch($qo, Queryable::HYDRATION_RESULTSET);
        Assert::type(Result::class, $result);
        Assert::count(1, $result->fetchAll());

        foreach ($books->findAll() as $b) {
            $books->removeAndFlush($b);
        }
    }

    /**
     * Test executable query object
     *
     * @return void
     */
    public function testExecutable()
    {
        /** @var BookRepository $books */
        $books = $this->container->getByType(BookRepository::class);

        $author = new User();
        $author->name = 'foobar3';

        $book = new Book();
        $book->name = 'foobar4';
        $book->author = $author;

        $books->persistAndFlush($book);

        /** @var QueryObjectContextAwareManager $qom */
        $qom = $this->container->getByType(QueryObjectManager::class);

        /** @var AllBooksExecutableQueryObject $qo */
        $qo = $qom->create(AllBooksExecutableQueryObject::class);
        $result = $qo->execute();

        $data = $result->fetchAll();
        Assert::type(Result::class, $result);
        Assert::count(1, $data);
        Assert::equal('foobar4', $data[0]->name);

        foreach ($books->findAll() as $b) {
            $books->removeAndFlush($b);
        }
    }

}

(new BooksTest($container))->run();
