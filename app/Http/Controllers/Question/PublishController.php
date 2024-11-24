<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class PublishController extends Controller
{
    public function __invoke(Question $question)
    {
        abort_unless($question->status === 'draft', 404, 'Question already published');

        if (!Gate::allows('publish', $question)) {
            abort(403);
        }

        $question->update(['status' => 1]);

        return response()->json(['message' => 'Question published successfully']);
    }
}
