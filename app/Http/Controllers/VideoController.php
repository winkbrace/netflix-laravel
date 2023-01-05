<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Netflix\Content\ImageType;
use Netflix\Content\Video;

class VideoController extends Controller
{
    public function hero()
    {
        /** @var Video $hero */
        $hero = Video::with('images')->inRandomOrder()->first();

        return [
            'title' => $hero['name'],
            'synopsis' => $hero['synopsis'],
            'background' => $hero->imageByType(ImageType::BACKGROUND),
            'logo' => $hero->imageByType(ImageType::LOGO),
        ];
    }

    public function all(Request $request)
    {
        return Video::with('images')->take(10)->get();
    }
}
