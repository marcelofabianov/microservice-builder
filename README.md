# MicroServiceBuilder

Pacote que vem para testar e validar estudo de arquitetura de software utilizando padrões como DTO.
Este pacote foi criado com objetivo de dar intefaces e classes abstradas para implementar e extender, geração de classes, arquivos e diretórios.

Para saber mais sobre estudo da arquitetura acesso o repositório: ...

## Instalação

A instalação é através do composer

```
composer require marcelofabianov/microservice-builder
```

Recomendo o uso do pacote somente em projetos com framework Laravel 9+ e PHP 8.1+

## Guia de uso

Com o pacote instalado em seu projeto Laravel execute em seu terminal

```
php artisan microservice-builder:make {stub} {module} {name}
```

Relação de stubs disponíveis

- Module
- Business
- Dto
- DtoTranslate
- ContainerFilters
- QueryFilter
- Repository
- SaveRepository
- Controller
- Request
- Resource
- Collection
- Service

Exemplo de uso

```
php artisan microservice-builder:make Dto Posts Comment
```
