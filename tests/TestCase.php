<?php

namespace Marcelofabianov\MicroServiceBuilder\Tests;

use Marcelofabianov\MicroServiceBuilder\MicroServiceBuilderServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        //
    }

    protected function getPackageProviders($app): array
    {
        return [
            MicroServiceBuilderServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
