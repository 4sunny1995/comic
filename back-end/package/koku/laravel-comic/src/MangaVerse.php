<?php

namespace Koku\LaravelComic;

use GuzzleHttp\Client;
use Koku\LaravelComic\Traits\HttpRequest;

class MangaVerse
{
    use HttpRequest;

    private string $host;
    private string $key;
    private Client $guzzle;

    public function __construct(string $key, string $host)
    {
        $this->initialCredentials($key, $host);
    }

    private function initialCredentials($key, $host)
    {
        $this->host = $host;
        $this->key = $key;
        $client = new Client([
            "headers" => [
                'X-RapidAPI-Host' => $this->host,
                'X-RapidAPI-Key' => $this->key,
            ]
        ]);
        $this->guzzle = $client;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient() : Client
    {
        return $this->guzzle;
    }
    public function setHttpClient(Client $client)
    {
        $this->guzzle = $client;
    }
}
