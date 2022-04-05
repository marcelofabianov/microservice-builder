<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\QueryFilters;

use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class BaseContainerFilters
{
    protected array $filters;

    private static array $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function new()
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        (self::$instances[$cls])->setFilters();

        return self::$instances[$cls];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return QueryBuilder
     */
    public function __call(string $name, array $arguments): QueryBuilder
    {
        return (new $this->filters[$name])->apply($arguments[0], $arguments[1]);
    }

    abstract protected function setFilters();
}
