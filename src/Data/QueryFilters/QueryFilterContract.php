<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\QueryFilters;

use Illuminate\Database\Query\Builder as QueryBuilder;

interface QueryFilterContract
{
    public function apply(QueryBuilder $queryBuilder, $data): QueryBuilder;
}
