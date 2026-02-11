<?php declare(strict_types = 1);

namespace Tests\Cases\E2E;

use Contributte\Nextras\Orm\QueryObject\Queryable;
use Contributte\Nextras\Orm\QueryObject\QueryObjectContextAwareManager;
use Contributte\Nextras\Orm\QueryObject\QueryObjectManager;
use Nette\DI\Container;
use Nextras\Dbal\Drivers\Exception\ConnectionException;
use Nextras\Dbal\IConnection;
use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;
use Tests\Mocks\Model\Book\AllBooksExecutableQueryObject;
use Tests\Mocks\Model\Book\AllBooksQueryObject;
use Tests\Mocks\Model\Book\Book;
use Tests\Mocks\Model\Book\BookRepository;
use Tests\Mocks\Model\User\User;

require_once __DIR__ . '/../../bootstrap.php';

// nextras/orm 5.0.x is not yet compatible with PHP 8.5 (null array offset in AbstractEntity)
if (PHP_VERSION_ID >= 80500) {
	Environment::skip('nextras/orm is not yet compatible with PHP 8.5');
}

$container = require_once __DIR__ . '/../../bootstrap.container.php';

/** @var IConnection $connection */
$connection = $container->getByType(IConnection::class);

try {
	$connection->connect();
} catch (ConnectionException $e) {
	Environment::skip('MySQL connection not available: ' . $e->getMessage());
}

final class BooksTest extends TestCase
{

	private Container $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Test empty results
	 */
	public function testEmpty(): void
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
	 */
	public function testHydration(): void
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
	 */
	public function testExecutable(): void
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

	protected function setUp(): void
	{
		/** @var IConnection $connection */
		$connection = $this->container->getByType(IConnection::class);
		$sql = file_get_contents(__DIR__ . '/../../Fixtures/mysql.sql');
		assert($sql !== false);

		foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
			$connection->query('%raw', $statement);
		}
	}

}

(new BooksTest($container))->run();
