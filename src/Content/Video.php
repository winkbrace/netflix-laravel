<?php

namespace Netflix\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'public.videos';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
