<?php

namespace App\Providers;

use App\Models\Abouts;
use App\Models\Banner;
use App\Models\DocumentCategories;
use App\Models\Menu;
use App\Models\Message;
use App\Models\PostCategories;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin' || $user->role === 'superadmin';
        });

        Gate::define('superadmin-access', function ($user) {
            return $user->role === 'superadmin';
        });

        Carbon::setLocale('id');

        // 🔔 Pesan belum dibaca (tanpa cache)
        View::composer(['components.*', 'admin.navbar'], function ($view) {
            $unreadMessages = Message::where('is_read', 0)->latest()->take(5)->get();
            $unreadCount = Message::where('is_read', 0)->count();

            $view->with(compact('unreadMessages', 'unreadCount'));
        });

        // Hanya untuk view components + sidebar (tanpa cache)
        View::composer(['components.*', 'admin.sidebar'], function ($view) {
            $unreadCount = Message::where('is_read', 0)->count();
            $view->with('unreadCount', $unreadCount);
        });


        // Banner (jarang berubah) → cache 1 jam
        View::share('banner', Cache::remember('banner', now()->addHour(), fn() => Banner::first()));

        // User login ke navbar admin
        View::composer('components.admin.navbar', function ($view) {
            $user = Auth::user();
            $about = Cache::remember('about_navbar', now()->addHour(), fn() => Abouts::select('white_logo', 'favicon')->first());
            $view->with(compact('user', 'about'));
        });

        // Layout admin
        View::composer('components.admin.layout', function ($view) {
            $about = Cache::remember('about_layout', now()->addHour(), fn() => Abouts::select('favicon')->first());
            $view->with(['about' => $about]);
        });

        // Kirim data User ke semua view layout
        View::composer('components.landingpage.layout', function ($view) {
            $about = Cache::remember('about_favicon', now()->addHour(), fn() => Abouts::select('favicon')->first());
            $view->with(['about' => $about]);
        });

        // Kirim data Document & Post Category ke navbar
        View::composer('components.landingpage.navbar', function ($view) {
            $documentCategories = Cache::remember(
                'document_categories',
                now()->addHour(),
                fn() =>
                DocumentCategories::where('is_published', 1)->orderBy('sort_order')->get()
            );

            $postCategories = Cache::remember(
                'post_categories',
                now()->addHour(),
                fn() =>
                PostCategories::where('is_published', 1)->orderBy('sort_order')->get()
            );

            $about = Cache::remember('about_logo', now()->addHour(), fn() => Abouts::select('white_logo', 'black_logo')->first());
            $menu = Cache::remember('menu', now()->addHour(), fn() => Menu::first());
            $services = Cache::remember('services', now()->addHour(), fn() => Service::take(5)->latest()->get());

            $view->with([
                'documentCategories' => $documentCategories,
                'postCategories' => $postCategories,
                'about' => $about,
                'menu' => $menu,
                'services' => $services
            ]);
        });

        // Footer
        View::composer('components.landingpage.footer', function ($view) {
            $documentCategories = Cache::remember(
                'document_categories_footer',
                now()->addHour(),
                fn() =>
                DocumentCategories::where('is_published', 1)->orderBy('sort_order', 'asc')->get()
            );

            $postCategories = Cache::remember(
                'post_categories_footer',
                now()->addHour(),
                fn() =>
                PostCategories::where('is_published', 1)->orderBy('sort_order', 'asc')->get()
            );

            $about = Cache::remember('about_footer', now()->addHour(), fn() => Abouts::first());
            $banner = Cache::remember('banner_footer', now()->addHour(), fn() => Banner::select('footer_background')->first());

            $view->with([
                'documentCategories' => $documentCategories,
                'postCategories' => $postCategories,
                'about' => $about,
                'banner' => $banner,
            ]);
        });
    }
}
