<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    protected $tagServices;
    public function __construct(TagService $tagServices)
    {
        $this->tagServices = $tagServices;
    }
    public function findTags(Request $request)
    {
        $name = $request->query("name");
        $name = ltrim($name, '@');
        return response()->json($this->tagServices->findTag($name));
    }
}
