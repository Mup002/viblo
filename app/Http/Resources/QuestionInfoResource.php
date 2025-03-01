<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['user'] = new UserQuestionResource($this->user);
        return $data;
    }
}
