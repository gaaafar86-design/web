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

        // لا تلمس قاعدة البيانات أثناء أوامر artisan (البناء، migrate، ...)
        if ($this->app->runningInConsole()) {
            return;
        }

        View::composer('front.layouts.footer', function ($view) {
            $footer = null;

            try {
                if (Schema::hasTable('footer')) {
                    $footer = Footer::first();
                }
            } catch (\Throwable $e) {
                // يكتب السبب الحقيقي في runtime logs
                report($e);
            }

            $view->with('footer', $footer);
        });

        try {
            if (
                Schema::hasTable('settings') &&
                Schema::hasColumn('settings', 'deleted_at')
            ) {
                View::share('setting', Setting::first());
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
