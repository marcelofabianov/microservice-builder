<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\DtoTranslate;

use Marcelofabianov\MicroServiceBuilder\Data\Dto\DtoContract;

abstract class BaseDtoTranslate implements DtoTranslateContract
{
    private static array $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @var array
     */
    protected array $translate = [
        'table' => '',
        'attributes' => [],
    ];

    public function set()
    {
        $this->translate['table'] = $this->table();
        $this->translate['attributes'] = $this->definingMapping();
    }

    public static function instance()
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        (self::$instances[$cls])->set();

        return self::$instances[$cls];
    }

    /**
     * @param  string $key
     * @return string
     */
    public function getAttributeSource(string $key): string
    {
        return $this->translate['attributes'][$key];
    }

    /**
     * @param  string $key
     * @return string
     */
    public function getAttributeDto(string $key): string
    {
        $attributes = array_flip($this->translate['attributes']);
        return $attributes[$key];
    }

    /**
     * @return array
     */
    public function getAttributesSource(): array
    {
        return array_values($this->translate['attributes']);
    }

    /**
     * @return array
     */
    public function getAttributesDto(): array
    {
        return array_keys($this->translate['attributes']);
    }

    /**
     * @param  DtoContract $dto
     * @return array
     */
    public function translateDtoFromSource(DtoContract $dto): array
    {
        $data = (array) $dto;
        $data['createdAt'] = $data['createdAt']->format('Y-m-d H:i:s');
        $data['updatedAt'] = $data['updatedAt']->format('Y-m-d H:i:s');

        $source = [];
        foreach ($data as $key => $value) {
            $source[$this->getAttributeSource($key)] = $value;
        }

        return $source;
    }

    /**
     * @param  array $source
     * @return DtoContract
     */
    abstract public function translateSourceFromDto(array $source): DtoContract;

    /**
     * @param  array $dataSource
     * @return array
     */
    public function translateCollectSourceFromDto(array $dataSource): array
    {
        $dataDto = [];
        foreach ($dataSource as $source) {
            $dataDto[] = $this->translateSourceFromDto((array) $source);
        }
        return $dataDto;
    }

    /**
     * @return array
     */
    public function translateSelectAlias(): array
    {
        $mapping = $this->definingMapping();

        $data =[];
        foreach ($mapping as $key => $value) {
            $data[] = $value.' as '.$key;
        }

        return $data;
    }

    /**
     * @return string
     */
    abstract public function table(): string;

    /**
     * @return array
     */
    abstract public function definingMapping(): array;
}
