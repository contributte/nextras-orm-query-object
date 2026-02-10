<?php declare(strict_types = 1);

namespace Tests\Mocks;

use EmptyIterator;
use Iterator;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Collection\MemoryCollection;
use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Mapper\IRelationshipMapper;
use RuntimeException;

/**
 * @implements ICollection<IEntity>
 */
final class StubCollection implements ICollection
{

	/**
	 * @param array<string, mixed>|array<mixed> $conds
	 */
	public function getBy(array $conds): ?IEntity
	{
		return null;
	}

	/**
	 * @param array<string, mixed>|array<mixed> $conds
	 */
	public function getByChecked(array $conds): IEntity
	{
		throw new RuntimeException();
	}

	public function getById(mixed $id): ?IEntity
	{
		return null;
	}

	public function getByIdChecked(mixed $id): IEntity
	{
		throw new RuntimeException();
	}

	/**
	 * @param array<mixed> $conds
	 */
	public function findBy(array $conds): ICollection
	{
		return $this;
	}

	/**
	 * @param string|array<string, string>|list<mixed> $expression
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
	 */
	public function orderBy($expression, string $direction = self::ASC): ICollection
	{
		return $this;
	}

	public function resetOrderBy(): ICollection
	{
		return $this;
	}

	public function limitBy(int $limit, int|null $offset = null): ICollection
	{
		return $this;
	}

	public function fetch(): ?IEntity
	{
		return null;
	}

	public function fetchChecked(): IEntity
	{
		throw new RuntimeException();
	}

	/**
	 * @return list<IEntity>
	 */
	public function fetchAll(): array
	{
		return [];
	}

	/**
	 * @return array<int|string, mixed>
	 */
	public function fetchPairs(string|null $key = null, string|null $value = null): array
	{
		return [];
	}

	/**
	 * @return Iterator<int, IEntity>
	 */
	public function getIterator(): Iterator
	{
		return new EmptyIterator();
	}

	public function count(): int
	{
		return 0;
	}

	public function countStored(): int
	{
		return 0;
	}

	public function toMemoryCollection(): MemoryCollection
	{
		throw new RuntimeException();
	}

	public function setRelationshipMapper(IRelationshipMapper|null $mapper): ICollection
	{
		return $this;
	}

	public function getRelationshipMapper(): ?IRelationshipMapper
	{
		return null;
	}

	public function setRelationshipParent(IEntity $parent): ICollection
	{
		return $this;
	}

	public function subscribeOnEntityFetch(callable $callback): void
	{
		// stub, intentionally empty
	}

}
