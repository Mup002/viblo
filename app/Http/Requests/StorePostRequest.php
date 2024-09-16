<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required|string',
            'tags'=>'required|array',
            'tags.*'=>[
                'numeric',
                'min: -9223372063854775808',
                'max: 9223372063854775808',
                'exists:tags,tag_id'
            ],
            'privacy_id'=>'required'
        ];
    }
}
