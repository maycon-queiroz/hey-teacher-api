<?php

namespace App\Http\Controllers\Question;

use App\Http\Requests\Question\DeleteRequest;
use App\Models\Question;

class DeleteController
{
    public function __invoke(Question $question, DeleteRequest $deleteRequest)
    {
        $question->delete();

        return response()->noContent();
    }

}
