<?php

namespace App\Http\Requests\Question;

use App\Models\Question;
use App\Rules\{OnlyAsDraft, WithQuestionMark};
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property-read string $question
 */
class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Question $question */
        $question = $this->route()->question; // @phpstan-ignore-line
        //        return (new QuestionPolicy)->update($this->user(), $question);

        return Gate::allows('update', $question);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var Question $question */
        $question = $this->route()->question;  // @phpstan-ignore-line

        return [
            'question' => [
                'required',
                'string',
                'min:10',
                'max:255',
                new OnlyAsDraft($question),
                new WithQuestionMark(),
                Rule::unique('questions')->ignore($question->id),
            ],
        ];
    }
}
