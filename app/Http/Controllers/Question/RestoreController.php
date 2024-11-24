<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class RestoreController extends Controller
{
    public function __invoke(int $int)
    {
        $question = Question::onlyTrashed()->findOrFail($int);

        if (!Gate::allows('restore', $question)) {
            abort(403);
        }

        $question->restore();

        return response()->json(['message' => 'Question restored successfully']);
    }
}
