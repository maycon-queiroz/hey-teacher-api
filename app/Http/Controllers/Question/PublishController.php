<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;

class PublishController extends Controller
{
    public function __invoke(Question $question)
    {
        $question->update(['status' => 1]);

        return response()->json(['message' => 'Question published successfully']);
    }
}
