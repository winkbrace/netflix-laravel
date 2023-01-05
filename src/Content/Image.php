<?php

namespace Netflix\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'public.images';
    protected $guarded = [];

    protected $casts = [
        'type' => ImageType::class,
    ];
}
