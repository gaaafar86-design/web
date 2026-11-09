<?php

namespace App\Providers;

use App\Models\Footer;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFour();

        View::composer('front.layouts.footer', function ($view) {
            if (Schema::hasTable('footer')) {
                $view->with(['footer' => Footer::first()]);
            }
        });

        if (
            Schema::hasTable('settings') &&
            Schema::hasColumn('settings', 'deleted_at')
        ) {
            View::share('setting', Setting::first());
        }
    }
}