<?php

namespace Marcelofabianov\MicroServiceBuilder;

use Illuminate\Support\ServiceProvider;
use Marcelofabianov\MicroServiceBuilder\Console\MicroServiceBuilderMakeCommand;
use Marcelofabianov\MicroServiceBuilder\Console\MicroServiceBuilderMakeModuleCommand;

class MicroServiceBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/microservice-builder.php', 'microservice-builder');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MicroServiceBuilderMakeCommand::class,
                MicroServiceBuilderMakeModuleCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/config/microservice-builder.php' => config_path('microservice-builder.php'),
            ], 'config');
        }
    }
}
