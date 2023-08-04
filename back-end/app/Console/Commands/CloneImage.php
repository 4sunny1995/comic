<?php

namespace App\Console\Commands;

use App\Services\ImageService;
use App\Services\MangaService;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CloneImage extends Command
{
    use ImageTrait;
    private $mangaService, $imageService;
    public function __construct(MangaService $mangaService, ImageService $imageService)
    {

        parent::__construct();
        $this->mangaService = $mangaService;
        $this->imageService = $imageService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comic:clone-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $mangas = $this->mangaService->getMangasHaveNotClone();
            foreach ($mangas as $manga) {
                $id = $manga->id;
                $data[] = [
                    'from_url' => $manga->thumb,
                    'storage_path' => "manga/$id/thumb.png",
                    'code' => "manga-$id-".Str::random(8),
                    'status' => 0
                ];
            }
            DB::beginTransaction();
            //insert new record
            $this->imageService->insertMultipleRow($data);

            //clone
            $images = $this->imageService->getCloneImage();
            foreach ($images as $image) {
                $url = $image->from_url;
                $storage_path = $image->storage_path;

                $this->cloneImage($url, $storage_path);
                $image->status = 1;
                $image->save();
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
        }
    }
}
