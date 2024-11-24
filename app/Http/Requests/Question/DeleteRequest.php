<?php

namespace App\Http\Requests\Question;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property-read string $question
 */
class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Question $question */
        $question = $this->route()->question; // @phpstan-ignore-line

        return Gate::allows('update', $question);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        ];
    }
}
