<?php

namespace App\Http\Controllers\Question;

use App\Models\Question;

class DeleteController
{
    public function __invoke(Question $question)
    {
        $question->delete();

        return response()->noContent();
    }

}
