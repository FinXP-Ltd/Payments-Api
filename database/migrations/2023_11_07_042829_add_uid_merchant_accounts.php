<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {

            if (Schema::connection(config('database.core_mysql'))->hasTable('merchant_accounts')) {

                Schema::connection(config('database.core_mysql'))->table('merchant_accounts', function (Blueprint $table) {

                    if (!Schema::connection(config('database.core_mysql'))->hasColumn('merchant_accounts', 'uuid')) {
                        $table->uuid('uuid')->unique()->after('id');
                    }

                });

            }

        } catch (Throwable $err) {
            info($err);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {

            if (Schema::connection(config('database.core_mysql'))->hasTable('merchant_accounts')) {

                Schema::connection(config('database.core_mysql'))->table('merchant_accounts', function (Blueprint $table) {

                    if (Schema::connection(config('database.core_mysql'))->hasColumn('merchant_accounts', 'uuid')) {
                        $table->dropColumn(['uuid']);
                    }

                });

            }

        } catch (Throwable $err) {
            info($err);
        }
    }
};
