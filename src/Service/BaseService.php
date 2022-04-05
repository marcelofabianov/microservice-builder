<?php

namespace Marcelofabianov\MicroServiceBuilder\Service;

abstract class BaseService implements ServiceContract
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $dataUpdate;

    /**
     * @var int
     */
    protected int $id;

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setDataUpdate(array $data)
    {
        unset($data['id']);
        $this->dataUpdate = $data;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    abstract public function execute(): array;
}
