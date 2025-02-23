<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $question = Question::query()
            ->published()
            ->search(request()->get('q', null))
            ->paginate();

        return QuestionResource::collection($question);
    }
}
