<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['user'] = new UserArticleInfoResource($this->user);
        $data['tags'] = TagResource::collection($this->tags);
        // dd($this->tags);
        return $data;
    }
}

