<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\Repository;

use Marcelofabianov\MicroServiceBuilder\Data\Dto\DtoContract;

interface SaveRepositoryContract
{
    /**
     * @param DtoContract $dto
     * @param int|null $id
     * @return array|null
     */
    public function save(DtoContract $dto, int $id = null): array|null;
}
