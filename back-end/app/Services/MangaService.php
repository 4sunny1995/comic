<?php
namespace App\Services;

use App\Models\Manga;
use App\Repositories\Interfaces\MangaInterface;
use Illuminate\Support\Facades\DB;

class MangaService
{
    private $mangaRepository;

    public function  __construct(MangaInterface $mangaRepository)
    {
        $this->mangaRepository =  $mangaRepository;
    }

    public function createManga(array $data)
    {
        return $this->mangaRepository->create($data);
    }

    public function insertMultipleRow(array $data)
    {
        if (count($data) == 0) {
            return [];
        }
        $attributes = array_keys($data[0]);
        $result = $this->mangaRepository->getModel()->upsert($data, $attributes);
        return  $result;
    }

    public function getMangasHaveNotClone()
    {
        return $this->mangaRepository->getMangasHaveNotClone();
    }
}
