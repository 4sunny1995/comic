<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    use HasFactory;

    protected $fillable = [
        'manga_id', 'title', 'sub_title', 'status', 'thumb', 'summary', 'type', 'genres', 'authors', 'nsfw', 'create_at', 'update_at', 'active'
    ];

    protected $casts = [
        'genres' => 'array',
        'authors' => 'array',
        'nsfw' => 'boolean',
        'active' => 'boolean',
        'create_at'=> 'datetime:Y-m-d H:i:s',
        'update_at'=> 'datetime:Y-m-d H:i:s',
        'created_at'=> 'datetime:Y-m-d H:i:s',
        'updated_at'=> 'datetime:Y-m-d H:i:s',
    ];


    //Mutator
    protected function authors(): Attribute
    {
        return Attribute::make(
            get: fn (string $v) => $v,
            set: fn (string $v) => json_encode($v)
        );
    }

    protected function genres(): Attribute
    {
        return Attribute::make(
            get: fn (string $v) => $v,
            set: fn (string $v) => json_encode($v)
        );
    }
}
