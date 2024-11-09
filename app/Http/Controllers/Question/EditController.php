<?php

namespace App\Http\Controllers\Question;

use App\Http\Requests\Question\UpdateRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;

class EditController
{
    public function __invoke(UpdateRequest $request, Question $question)
    {
        $question->question = $request->question;
        $question->save();

        return QuestionResource::make($question);
    }

}
