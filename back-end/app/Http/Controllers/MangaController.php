<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\MangaInterface;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    private $mangaInterface;
    public function  __construct(MangaInterface $mangaInterface)
    {
        $this->mangaInterface = $mangaInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->mangaInterface->advancedGet([
            'paginate' => [
                'per_page' => 20,
                'current_paged' => 1,
            ],
        ]);
        // $tranformer =
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
