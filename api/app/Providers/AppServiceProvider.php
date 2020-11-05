<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('library').'/autofunctions.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!empty(request()->all()['debug_db'])) {
            DB::connection('mysql')->listen(function ($query) {
                var_dump([$query->sql, $query->time]);
            });
        }
    }
}
