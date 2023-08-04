<?php

namespace App\Console\Commands;

use App\Constants\ImageConstant;
use App\Constants\MangaConstant;
use App\Models\History;
use App\Services\MangaService;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Koku\LaravelComic\MangaVerse;

class FetchManga extends Command
{
    use ImageTrait;

    private $mangaService;
    public function __construct(MangaService $mangaService)
    {

        parent::__construct();
        $this->mangaService = $mangaService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comic:fetch-manga';

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
        $credentinals = config('koku.credentinals');
        $key = $credentinals['api_key'] ?? '';
        $host = $credentinals['api_host'] ?? '';
        $url = $credentinals['api_url'] ?? '';
        $manga_verse = new MangaVerse($key, $url);
        $history = History::where('name', MangaConstant::FETCH_MANGA_PREFIX)->latest()->first();
        try {
            $url = $host . MangaConstant::FETCH_MANGA_PREFIX;
            $page = !empty($history) ? $history->page + 1 : 1;
            // while(true) {
                $query = [
                    "page" => $page
                ];
                $response = $manga_verse->get($url, $query);
                $result = json_decode($response->getBody()->getContents(), true);

                if (!empty($result['data'])) {
                    $data = $result['data'];

                    foreach($data as &$row) {
                        $row['manga_id'] = $row['id'];
                        $row['authors'] = json_encode($row['authors']);
                        $row['genres'] = json_encode($row['genres']);

                        unset($row['id']);
                        $item = $this->mangaService->createManga($row);
                        if ($row['thumb']) {
                            $storage_path = ImageConstant::getStoragePath($item->id);
                            $this->cloneImage($row['thumb'], $storage_path);
                            $item->thumb = $storage_path;
                            $item->save();
                        }
                    }
                    // $this->mangaService->insertMultipleRow($data);

                    History::create([
                        'name' => MangaConstant::FETCH_MANGA_PREFIX,
                        'query' => json_encode($query),
                        'page' => $page
                    ]);
                    $page++;
                }

            // }
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
