<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\MangaInterface;

class MangaRepository extends RepositoriesAbstract implements MangaInterface
{
    public function getMangasHaveNotClone()
    {
        return $this->getModel()
                    ->take(1)
                    ->get();
    }
}
