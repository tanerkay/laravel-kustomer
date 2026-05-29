<?php

namespace Mydnic\Kustomer\Test;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Mydnic\Kustomer\KustomerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [KustomerServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $config = $app->get('config');
        $config->set('logging.default', 'errorlog');
        $config->set('database.default', 'testbench');
        $config->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase(): void
    {
        Schema::dropIfExists('feedbacks');

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->text('message');
            $table->text('user_info')->nullable();
            $table->boolean('reviewed')->default(false);
            $table->timestamps();
        });
    }
}
