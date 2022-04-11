# MicroServiceBuilder

Pacote que vem para testar e validar estudo de arquitetura de software utilizando padrões como DTO.
Este pacote foi criado com objetivo de dar intefaces e classes abstradas para implementar e extender, geração de classes, arquivos e diretórios.

Pacote para usar com o framework [Laravel](https://laravel.com/)

## Instalação

A instalação é através do composer

```
composer require marcelofabianov/microservice-builder
```

Publicar arquivo de configuração (opcional)

```
php artisan vendor:publish --provider="Marcelofabianov/MicroServiceBuilderServiceProvider.php" --tag="config"
```

No seu projeto na pasta config você irá encontrar microservice-builder.php, neste arquivo você poderá definir as suas configurações (opcional)

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
