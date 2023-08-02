<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\Manga;
use App\Repositories\Eloquent\ImageRepository;
use App\Repositories\Eloquent\MangaRepository;
use App\Repositories\Interfaces\ImageInterface;
use App\Repositories\Interfaces\MangaInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MangaInterface::class, function () {
            return new MangaRepository(new Manga());
        });
        $this->app->bind(ImageInterface::class, function () {
            return new ImageRepository(new Image());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
