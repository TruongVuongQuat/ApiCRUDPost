<?php

namespace VCComponent\Laravel\TestPostManage\Tests;

use VCComponent\Laravel\TestPostManage\Providers\PostServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            PostServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver'   => 'mysql',
            'database' => 'post_manage',
            'prefix'   => '',
            'username' => 'root',
            'host' => '127.0.0.1'
        ]);
    }
}
