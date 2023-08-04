<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function cloneImage(string $url, string $storagePath)
    {
        try {
            Storage::put($storagePath, file_get_contents($url));
            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }
}
