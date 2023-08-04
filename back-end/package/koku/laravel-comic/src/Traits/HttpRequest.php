<?php
namespace Koku\LaravelComic\Traits;

trait HttpRequest
{
    public function get(string $url, $query = [])
    {
       return $this->getHttpClient()->get($url, ['query' => $query]);
    }

    public function post(string $url, array $data = [])
    {
       return $this->getHttpClient()->post($url, $data);
    }

    public function put(string $url, array $data = [])
    {
       return $this->getHttpClient()->put($url, $data);
    }

    public function patch(string $url, array $data = [])
    {
       return $this->getHttpClient()->patch($url, $data);
    }

    public function delete(string $url, array $data = [])
    {
       return $this->getHttpClient()->delete($url, $data);
    }
}
