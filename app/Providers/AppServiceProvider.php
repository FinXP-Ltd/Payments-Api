<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->_registerMacro();
    }

    private function _registerMacro()
    {
        Request::macro(
            'allFilled',
            function (array $keys) {
                foreach ($keys as $key) {
                    if (! $this->filled($key)) {
                        return false;
                    }
                }

                return true;
            }
        );

        Builder::macro('orWhereLike', function($column, $search) {
            return $this->orWhere($column, 'LIKE', "%{$search}%");
        });
    }
}
