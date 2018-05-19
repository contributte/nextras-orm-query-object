<?php declare(strict_types = 1);

namespace Tests\Mocks\Model;

use Nextras\Orm\Mapper\Memory\ArrayMapper;

final class SimpleArrayMapper extends ArrayMapper
{

	/** @var mixed[] */
	protected $data;

	/**
	 * @return mixed[]
	 */
	protected function readData(): array
	{
		return $this->data;
	}

	/**
	 * @param mixed[] $data
	 */
	protected function saveData(array $data): void
	{
		$this->data = $data;
	}

}
