<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength( 191 );

        Blueprint::macro( 'userlog', function () {
            $this->string( 'created_by', 100 )->nullable();
            $this->string( 'created_ip', 50 )->nullable();
            $this->string( 'updated_by', 100 )->nullable();
            $this->string( 'updated_ip', 50 )->nullable();
        } );
    }
}
