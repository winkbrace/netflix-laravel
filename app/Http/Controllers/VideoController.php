<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Netflix\Content\Video;

class VideoController extends Controller
{
    public function all(Request $request)
    {
        return Video::with('images')->take(10)->get();
    }
}
