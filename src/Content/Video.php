<?php

namespace Netflix\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'public.videos';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function imageByType(ImageType $type): ?Image
    {
        if (empty($this->images)) {
            return null;
        }

        return $this->images->where('type', $type)->first();
    }
}
