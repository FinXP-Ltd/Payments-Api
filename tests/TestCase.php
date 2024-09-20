<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $migrationsRun = false;

    protected $connectionsToTransact = ['mysql_testing', 'core_mysql_testing'];

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        if (!static::$migrationsRun) {
            $this->artisan('migrate:fresh');

            $this->artisan('db:seed');
            static::$migrationsRun = true;
        }
    }


    protected function setUpDatabase($app): void
    {
        $isCoreMerchantExist = Schema::connection('core_mysql_testing')->hasTable('merchants');

        if (! $isCoreMerchantExist) {
            $app['db']
            ->connection('core_mysql_testing')
            ->getSchemaBuilder()
            ->create('merchants', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->unique();
                $table->string('name', 150);
                $table->string('short_code', 10)->nullable();
                $table->string('slug')->unique();
                $table->string('point_of_contact')->nullable();
                $table->string('street')->nullable();
                $table->string('unit_no')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('postal')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_iso')->default(false);
                $table->boolean('skip_computation')->default(false);
                $table->string('customer_number')->nullable();
                $table->timestamps();
            });
        }

        $isCoreMerchanAccounttExist = Schema::connection('core_mysql_testing')->hasTable('merchants');

        if (! $isCoreMerchanAccounttExist) {
            $app['db']
            ->connection('core_mysql_testing')
            ->getSchemaBuilder()
            ->create('merchant_accounts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('merchant_id');
                $table->string('account_number');
                $table->string('iban_number')->nullable();
                $table->string('account_desc')->nullable();
                $table->boolean('is_notification_active')->default(false);
                $table->timestamps();

                $table->foreign('merchant_id')
                    ->references('id')
                    ->on('merchants');
            });
        }

        $isCoreApiAccessExist = Schema::connection('core_mysql_testing')->hasTable('api_access');
        if(! $isCoreApiAccessExist) {

            $app['db']
            ->connection('core_mysql_testing')
            ->getSchemaBuilder()
            ->create('api_access', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key', 36);
                $table->string('secret', 36);
                $table->string('description')->nullable();
                $table->unsignedBigInteger('merchant_id');
                $table->boolean('revoked')->default(false);
                $table->timestamps();

                $table->foreign('merchant_id')
                    ->references('id')
                    ->on('merchants')
                    ->onDelete('cascade');

                $table->unique(['key', 'secret']);
            });
        }
    }
}
