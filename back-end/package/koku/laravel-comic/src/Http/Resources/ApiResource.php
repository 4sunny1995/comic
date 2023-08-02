<?php
namespace Koku\LaravelComic\Http\Resources;

use Exception;
use Koku\LaravelComic\MangaVerse;

class ApiResource
{
    protected MangaVerse $mangaVerse;
    protected array $attributes = [];

    public function __construct(array $attributes, MangaVerse $mangaVerse)
    {
        $this->attributes = $attributes;
        $this->mangaVerse = $mangaVerse;
    }

    protected function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        throw new Exception("The $key field missing in array.");
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function toArray()
    {
        return $this->getAttributes();
    }
}
