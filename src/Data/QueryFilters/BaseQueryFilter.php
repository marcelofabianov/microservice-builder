<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\QueryFilters;

use Marcelofabianov\MicroServiceBuilder\Data\DtoTranslate\DtoTranslateContract as Translate;

abstract class BaseQueryFilter
{
    protected Translate $translate;

    public function __construct()
    {
        $this->setTranslate();
    }

    abstract protected function setTranslate();
}
