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
            'background' => $hero->imageByType(ImageType::BACKGROUND)?->url,
            'logo' => $hero->imageByType(ImageType::LOGO)?->url,
        ];
    }

    public function search(Request $request, string $search)
    {
        $videos = Video::with('images')
            ->where('type', $search)
            ->orWhere('release_year', (int) $search)
            ->orWhere('name', 'ilike', "%$search%")
            ->orWhere('synopsis', 'ilike', "%$search%")
            ->orWhere('genres', 'ilike', "%$search%")
            ->orWhere('tags', 'ilike', "%$search%")
            ->take(20)
            ->get()
            ->toArray(); // without casting to array first, the 'images' would not get overwritten.

        foreach ($videos as &$video) {
            $video['images'] = collect($video['images'])
                ->mapWithKeys(function ($img) {
                    return [$img['type'] => $img['url']];
                })->all();
        }

        return $videos;
    }

    public function all(Request $request)
    {
        return Video::with('images')->take(10)->get();
    }
}
