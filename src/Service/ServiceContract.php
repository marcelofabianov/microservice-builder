<?php

namespace Marcelofabianov\MicroServiceBuilder\Service;

interface ServiceContract
{
    /**
     * @param array $data
     */
    public function setData(array $data);

    /**
     * @param array $data
     */
    public function setDataUpdate(array $data);

    /**
     * @param int $id
     */
    public function setId(int $id);

    /**
     * @return array
     */
    public function execute(): array;
}
