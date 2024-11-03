<?php

namespace App\Http\Requests\Question;

use App\Rules\WithQuestionMark;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $question
 */
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => [
                'required',
                'string',
                'min:10',
                'max:255',
                new WithQuestionMark,
                'unique:questions,question',
            ],
        ];
    }
}
