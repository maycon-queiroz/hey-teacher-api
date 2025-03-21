<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Resources\QuestionResource;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): QuestionResource
    {
        $question = user()->questions()->create([
            'question' => $request->question,
        ]);

        return QuestionResource::make($question);
    }
}
