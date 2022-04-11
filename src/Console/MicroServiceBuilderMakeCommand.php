<?php

namespace Marcelofabianov\MicroServiceBuilder\Console;

use Illuminate\Console\Command;

class MicroServiceBuilderMakeCommand extends Command
{
    protected $signature = 'microservice-builder:make {stub} {module} {name}';

    protected $description = 'Make command Stubs Class';

    public function handle()
    {
        $make = new MakeStub();
        $make->makeStubInit($this->argument('module'),$this->argument('name'),$this->argument('stub'));

        $config = config('microservice-builder');
        $this->info('MicroService Builder');
        $this->info('Creating: '. $this->argument('stub'));
        $this->info('path: '.$make->makeStub());
        $this->info('namespace: '.$config['ROOT_NAMESPACE']);
    }
}
