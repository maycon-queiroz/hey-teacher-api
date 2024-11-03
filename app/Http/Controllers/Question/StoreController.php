<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $question = Question::query()->create([
            'question' => $request->question,
            'user_id'  => auth()->id(),
        ]);

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
