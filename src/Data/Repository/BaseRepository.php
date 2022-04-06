<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\Repository;

use Illuminate\Support\Facades\DB;
use Marcelofabianov\MicroServiceBuilder\Data\DtoTranslate\DtoTranslateContract as Translate;
use Marcelofabianov\MicroServiceBuilder\Data\QueryFilters\QueryContainerFiltersContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class BaseRepository
{
    /**
     * @var ConnectionInterface
     */
    protected ConnectionInterface $connection;

    /**
     * @var Translate
     */
    protected Translate $translate;

    /**
     * @var QueryContainerFiltersContract
     */
    protected QueryContainerFiltersContract $filter;

    /**
     * @var string
     */
    protected string $tableName;

    /**
     * @var string
     */
    protected string $primaryKeyName;

    /**
     * Define Default Connection Use
     */
    public function __construct($nameConnection = null)
    {
        $this->connection = DB::connection(env('DB_CONNECTION', $nameConnection));

        $this->init();

        $this->tableName = $this->translate->table();

        $mapping = $this->translate->definingMapping();
        $this->primaryKeyName = $mapping['id'];
    }

    /**
     * Método deve ser implementado em todos os repositories
     * Para setar o objeto que será utilizado como "translate" e "filter container"
     */
    abstract protected function init();

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id): object|null
    {
        return $this->connection
            ->table($this->tableName)
            ->select($this->translate->translateSelectAlias())
            ->where($this->primaryKeyName, $id)
            ->first();
    }

    /**
     * @return QueryBuilder
     */
    public function get(): QueryBuilder
    {
        return $this->connection
            ->table($this->tableName)
            ->select($this->translate->translateSelectAlias());
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->connection->table($this->tableName)->insert($data);
    }

    /**
     * @param array $data
     * @return int
     */
    public function insertGetId(array $data): int
    {
        return $this->connection->table($this->tableName)->insertGetId($data, $this->primaryKeyName);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->connection->table($this->tableName)->where($this->primaryKeyName, $id)->update($data);
    }
}
