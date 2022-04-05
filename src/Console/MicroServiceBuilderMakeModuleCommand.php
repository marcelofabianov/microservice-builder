<?php

namespace Marcelofabianov\MicroServiceBuilder\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MicroServiceBuilderMakeModuleCommand extends Command
{
    protected $signature = 'microservice-builder:make-module {name}';

    protected $description = 'Make Module';

    public function handle()
    {
        $name = $this->argument('name');
        $this->info('Create Module: app/'. $name);

        $make = new MakeStub();
        $make->makeModule($name);

        // Make Controller Welcome
        Artisan::call('microservice-builder:make', [
            'stub' => 'Controller',
            'module' => $name,
            'name' => 'Welcome'
        ]);

        // Make routes
        Artisan::call('microservice-builder:make', [
            'stub' => 'routes',
            'module' => $name,
            'name' => ''
        ]);

        $this->info('Finish Module: app/'. $name);
    }
}
