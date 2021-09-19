<?php


namespace Tests;


use Chareice\TencentCloud\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    public function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('tencent_cloud', [
            'secret_id' => 'test',
            'secret_key' => 'test',
            'region' => 'test'
        ]);
    }

    /**
     * run package database migrations.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }
}