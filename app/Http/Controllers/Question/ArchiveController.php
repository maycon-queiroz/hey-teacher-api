<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class ArchiveController extends Controller
{
    public function __invoke(Question $question)
    {
        if (!Gate::allows('archive', $question)) {
            abort(403);
        }

        $question->delete();

        return response()->noContent();
    }
}
