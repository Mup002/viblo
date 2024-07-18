<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyOneField implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $input = request()->all();
        if((!isset($input['article_id']) && !isset($input['question_id']))
        || (isset($input['article_id']) && isset($input['question_id'])))
    {
        $fail('Need article or question info u want to comment?');
    }
    }
}
