<?php

namespace Marcelofabianov\MicroServiceBuilder\Console;

use Illuminate\Filesystem\Filesystem;
use JetBrains\PhpStorm\ArrayShape;

class MakeStub
{
    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     * @var string
     */
    protected string $module;

    /**
     * @var string
     */
    protected string $className;

    /**
     * @var string
     */
    protected string $stubType;

    /**
     * @var string
     */
    protected string $namespace;

    /**
     * @var string
     */
    protected string $rootDir;

    /**
     * @var array|string[]
     */
    protected array $pathGenerate = [
        'Business' => '{ROOT_DIR}/{MODULE}/Business',
        'Dto' => '{ROOT_DIR}/{MODULE}/Data/Dto',
        'DtoTranslate' => '{ROOT_DIR}/{MODULE}/Data/DtoTranslate',
        'ContainerFilters' => '{ROOT_DIR}/{MODULE}/Data/QueryFilters',
        'QueryFilter' => '{ROOT_DIR}/{MODULE}/Data/QueryFilters',
        'Repository' => '{ROOT_DIR}/{MODULE}/Data/Repositories',
        'SaveRepository' => '{ROOT_DIR}/{MODULE}/Data/Repositories',
        'Controller' => '{ROOT_DIR}/{MODULE}/Http/Controllers',
        'Request' => '{ROOT_DIR}/{MODULE}/Http/Requests',
        'Resource' => '{ROOT_DIR}/{MODULE}/Http/Resources',
        'Collection' => '{ROOT_DIR}/{MODULE}/Http/Resources',
        'Service' => '{ROOT_DIR}/{MODULE}/Service',
        'Data' => '{ROOT_DIR}/{MODULE}/Data',
        'Enums' => '{ROOT_DIR}/{MODULE}/Data/Enums',
        'Http' => '{ROOT_DIR}/{MODULE}/Http',
        'routes' => '{ROOT_DIR}/{MODULE}',
    ];

    /**
     * @var array|string[]
     */
    protected array $namespaceGenerate = [
        'Business' => '{ROOT_NAMESPACE}\{MODULE}\Business',
        'Dto' => '{ROOT_NAMESPACE}\{MODULE}\Data\Dto',
        'DtoTranslate' => '{ROOT_NAMESPACE}\{MODULE}\Data\DtoTranslate',
        'ContainerFilters' => '{ROOT_NAMESPACE}\{MODULE}\Data\QueryFilters',
        'QueryFilter' => '{ROOT_NAMESPACE}\{MODULE}\Data\QueryFilters',
        'Repository' => '{ROOT_NAMESPACE}\{MODULE}\Data\Repositories',
        'SaveRepository' => '{ROOT_NAMESPACE}\{MODULE}\Data\Repositories',
        'Controller' => '{ROOT_NAMESPACE}\{MODULE}\Http\Controllers',
        'Request' => '{ROOT_NAMESPACE}\{MODULE}\Http\Requests',
        'Resource' => '{ROOT_NAMESPACE}\{MODULE}\Http\Resources',
        'Collection' => '{ROOT_NAMESPACE}\{MODULE}\Http\Resources',
        'Service' => '{ROOT_NAMESPACE}\{MODULE}\Service',
    ];

    /**
     * @param string $module
     * @param string $className
     * @param string $stubType
     */
    public function makeStubInit(string $module, string $className, string $stubType)
    {
        $this->initConfig();
        $this->setLibFiles();
        $this->module = $module;
        $this->className = $className;
        $this->stubType = $stubType;

    }

    public function initConfig()
    {
        $config = config('microservice-builder');

        $this->namespace = $config['ROOT_NAMESPACE'];
        $this->rootDir = $config['ROOT_DIR'];

        foreach ($this->namespaceGenerate as $key => $value) {
            $namespace = str_replace('{ROOT_NAMESPACE}', $config['ROOT_NAMESPACE'], $value);
            $this->namespaceGenerate[$key] = $namespace;
        }

        foreach ($this->pathGenerate as $key => $value) {
            $path = str_replace('{ROOT_DIR}', $config['ROOT_NAMESPACE'], $value);
            $this->pathGenerate[$key] = $path;
        }
    }

    public function setLibFiles()
    {
        $this->files = new Filesystem;
    }

    public function makeStub(): string
    {
        $path = $this->getSourceFilePathStub();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            return "Stub: ".$this->stubType." File : {$path} created";
        } else {
            return "Stub: ".$this->stubType."File : {$path} already exits";
        }
    }

    public function makeModule($module)
    {
        $this->setLibFiles();
        $this->initConfig();

        $this->makeDirectory(base_path($this->rootDir.'/'.$module));

        foreach ($this->pathGenerate as $subDirectory) {
            $subPath = str_replace('{MODULE}', $module, $subDirectory);
            $this->makeDirectory(base_path($subPath));
        }
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     */
    #[ArrayShape(['NAMESPACE' => "string", 'CLASS_NAME' => "string"])]
    public function getStubVariables(): array
    {
        $namespace = '';
        if (isset($this->namespaceGenerate[$this->stubType])) {
            $namespace = $this->namespaceGenerate[$this->stubType];
            $namespace = str_replace('{MODULE}', $this->module, $namespace);
        }

        return [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $this->className . $this->stubType,
        ];
    }

    /**
     * Return the stub file path
     *
     * @return string
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/../stubs/'.$this->stubType.'.stub';
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|string
     */
    public function getSourceFile(): bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    public function getSourceFilePathStub(): string
    {
        $path = $this->pathGenerate[$this->stubType];
        $path = str_replace('{MODULE}', $this->module, $path);

        return base_path($path.'/'.$this->className.$this->stubType.'.php');
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param string $stub
     * @param array $stubVariables
     * @return bool|string
     */
    public function getStubContents(string $stub, array $stubVariables = []): bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    public function makeDirectory(string $path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
