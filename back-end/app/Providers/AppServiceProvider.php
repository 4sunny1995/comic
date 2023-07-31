<?php

namespace App\Providers;

use App\Models\Manga;
use App\Repositories\Eloquent\MangaRepository;
use App\Repositories\Eloquent\RepositoriesAbstract;
use App\Repositories\Interface\BaseInterface;
use App\Repositories\Interfaces\MangaInterface;
use Illuminate\Support\ServiceProvider;
use Koku\LaravelComic\MangaVerse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(BaseInterface::class, RepositoriesAbstract::class);
        $this->app->bind(MangaInterface::class, function () {
            return new MangaRepository(new Manga());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
