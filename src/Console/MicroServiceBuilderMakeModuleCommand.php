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

        $config = config('microservice-builder');
        $this->info('MicroService Builder');
        $this->info('Creating Module: '. $name);
        $this->info('path: '.$config['ROOT_DIR']);
        $this->info('namespace: '.$config['ROOT_NAMESPACE']);
    }
}
