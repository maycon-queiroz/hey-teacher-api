<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): QuestionResource
    {
        $question = Question::query()->create([
            'question' => $request->question,
            'user_id'  => auth()->id(),
        ]);

        return QuestionResource::make($question);

        return response()->json([
            'data' => [
                'id'         => $question->id,
                'question'   => $question->question,
                'status'     => $question->status,
                'created_at' => $question->created_at->format('Y-m-d'),
                'updated_at' => $question->updated_at->format('Y-m-d'),
            ],
        ], Response::HTTP_CREATED);
    }
}
