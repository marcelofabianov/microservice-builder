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
     * @var array|string[]
     */
    protected array $pathGenerate = [
        'Business' => 'app/{MODULE}/Business',
        'Dto' => 'app/{MODULE}/Data/Dto',
        'DtoTranslate' => 'app/{MODULE}/Data/DtoTranslate',
        'ContainerFilters' => 'app/{MODULE}/Data/QueryFilters',
        'QueryFilter' => 'app/{MODULE}/Data/QueryFilters',
        'Repository' => 'app/{MODULE}/Data/Repositories',
        'SaveRepository' => 'app/{MODULE}/Data/Repositories',
        'Controller' => 'app/{MODULE}/Http/Controllers',
        'Request' => 'app/{MODULE}/Http/Requests',
        'Resource' => 'app/{MODULE}/Http/Resources',
        'Collection' => 'app/{MODULE}/Http/Resources',
        'Service' => 'app/{MODULE}/Service',
        'Data' => 'app/{MODULE}/Data',
        'Enums' => 'app/{MODULE}/Data/Enums',
        'Http' => 'app/{MODULE}/Http',
        'routes' => 'app/{MODULE}',
    ];

    /**
     * @var array|string[]
     */
    protected array $namespaceGenerate = [
        'Business' => 'App\{MODULE}\Business',
        'Dto' => 'App\{MODULE}\Data\Dto',
        'DtoTranslate' => 'App\{MODULE}\Data\DtoTranslate',
        'ContainerFilters' => 'App\{MODULE}\Data\QueryFilters',
        'QueryFilter' => 'App\{MODULE}\Data\QueryFilters',
        'Repository' => 'App\{MODULE}\Data\Repositories',
        'SaveRepository' => 'App\{MODULE}\Data\Repositories',
        'Controller' => 'App\{MODULE}\Http\Controllers',
        'Request' => 'App\{MODULE}\Http\Requests',
        'Resource' => 'App\{MODULE}\Http\Resources',
        'Collection' => 'App\{MODULE}\Http\Resources',
        'Service' => 'App\{MODULE}\Service',
    ];

    /**
     * @param string $module
     * @param string $className
     * @param string $stubType
     */
    public function makeStubInit(string $module, string $className, string $stubType)
    {
        $this->setLibFiles();
        $this->module = $module;
        $this->className = $className;
        $this->stubType = $stubType;
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

        $this->makeDirectory(base_path('app/'.$module));

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
