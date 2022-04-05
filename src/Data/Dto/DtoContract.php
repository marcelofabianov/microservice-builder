<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\Dto;

interface DtoContract
{
    /**
     * @param array $input
     */
    public static function from(array $input);
}
