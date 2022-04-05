<?php

namespace Marcelofabianov\MicroServiceBuilder\Data\DtoTranslate;

use Marcelofabianov\MicroServiceBuilder\Data\Dto\DtoContract;

interface DtoTranslateContract
{
    /**
     * Define a tabela alvo
     */
    public function table(): string;

    /**
     * Define os atributos do Dto como chaves e o valor respondente da Source
     */
    public function definingMapping();

    /**
     * Cria a estrutura da string para após ser utilizada SELECT {ALIAS} FROM ...
     *
     * @return array
     */
    public function translateSelectAlias(): array;

    /**
     * Retorna nome do atributo da Source informando nome conforme Dto
     *
     * @param  string $key
     * @return string
     */
    public function getAttributeSource(string $key): string;

    /**
     * Retorna uma lista de nome dos atributos da Source
     *
     * @return array
     */
    public function getAttributesSource(): array;

    /**
     * Retorna nome do atributo da Dto informando nome conforme Source
     *
     * @param  string $key
     * @return string
     */
    public function getAttributeDto(string $key): string;

    /**
     * @return array
     */
    public function getAttributesDto(): array;

    /**
     * Converte os nomes dos atributos do Dto nomes dos atributos do Source
     *
     * @param  DtoContract $dto
     * @return array
     */
    public function translateDtoFromSource(DtoContract $dto): array;

    /**
     * Converte os nomes dos atributos do Source para padrão definido no Dto
     *
     * @param  array $source
     * @return DtoContract
     */
    public function translateSourceFromDto(array $source): DtoContract;

    /**
     * Recebe uma coleção de dados vindos Source e converte cada registro no formato do Dto
     *
     * @param  array $dataSource
     * @return array
     */
    public function translateCollectSourceFromDto(array $dataSource): array;
}
