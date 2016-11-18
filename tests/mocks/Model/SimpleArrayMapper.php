<?php

namespace Tests\Mocks\Model;

use Nextras\Orm\Mapper\Memory\ArrayMapper;

final class SimpleArrayMapper extends ArrayMapper
{

    /** @var array */
    protected $data;

    /**
     * @return array
     */
    protected function readData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return void
     */
    protected function saveData(array $data)
    {
        $this->data = $data;
    }

}
