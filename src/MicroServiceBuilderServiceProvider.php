<?php

namespace Marcelofabianov\MicroServiceBuilder;

use Illuminate\Support\ServiceProvider;
use Marcelofabianov\MicroServiceBuilder\Console\MicroServiceBuilderMakeCommand;
use Marcelofabianov\MicroServiceBuilder\Console\MicroServiceBuilderMakeModuleCommand;

class MicroServiceBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MicroServiceBuilderMakeCommand::class,
                MicroServiceBuilderMakeModuleCommand::class,
            ]);
        }
    }
}
