<?php

namespace App\Observers;

use App\Models\Manga;

class MangaObserver
{
    /**
     * Handle the Manga "created" event.
     */
    public function created(Manga $manga): void
    {
        \Log::info('133');
    }

    /**
     * Handle the Manga "updated" event.
     */
    public function updated(Manga $manga): void
    {
        //
    }

    /**
     * Handle the Manga "deleted" event.
     */
    public function deleted(Manga $manga): void
    {
        //
    }

    /**
     * Handle the Manga "restored" event.
     */
    public function restored(Manga $manga): void
    {
        //
    }

    /**
     * Handle the Manga "force deleted" event.
     */
    public function forceDeleted(Manga $manga): void
    {
        //
    }
}
