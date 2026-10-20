<?php

namespace App\Providers;

use App\Models\Footer;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFour();

        /*
         * أثناء composer install وعمليات البناء تكون قاعدة البيانات
         * غير جاهزة أحياناً، لذلك لا نفحص الجداول أثناء أوامر Console.
         */
        if (app()->runningInConsole()) {
            return;
        }

        /*
         * مشاركة إعدادات الموقع مع جميع الصفحات.
         */
        try {
            if (
                Schema::hasTable('settings') &&
                Schema::hasColumn('settings', 'deleted_at')
            ) {
                View::share('setting', Setting::first());
            }
        } catch (Throwable $exception) {
            /*
             * تجاهل الخطأ مؤقتاً إذا لم تكن قاعدة البيانات جاهزة.
             */
        }

        /*
         * تمرير بيانات التذييل إلى قالب الفوتر.
         */
        View::composer('front.layouts.footer', function ($view): void {
            try {
                if (Schema::hasTable('footer')) {
                    $view->with([
                        'footer' => Footer::first(),
                    ]);
                }
            } catch (Throwable $exception) {
                /*
                 * عدم إيقاف الموقع إذا لم يكن جدول الفوتر موجوداً.
                 */
            }
        });
    }
}
