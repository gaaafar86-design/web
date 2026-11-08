<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * تسجيل خدمات التطبيق.
     */
    public function register(): void
    {
        //
    }

    /**
     * تشغيل خدمات التطبيق.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | لا تفحص قاعدة البيانات أثناء أوامر Artisan والبناء
        |--------------------------------------------------------------------------
        */
        if (app()->runningInConsole()) {
            return;
        }

        try {
            if (Schema::hasTable('settings')) {
                view()->share(
                    'setting',
                    Setting::first()
                );
            }
        } catch (\Throwable $e) {
            // لا نوقف الموقع إذا لم تكن قاعدة البيانات جاهزة
        }
    }
}
