<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserArticleInfoResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'display_name' => $this->display_name,
            'username' => '@' . $this->username,
            'reputation' => $this->reputation,
            'user_follow' => $this->user_follow,
            'article' => $this-> article,
            'avt_url' => $this->avt_url
        ];
    }
}
