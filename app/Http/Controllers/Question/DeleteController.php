<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function __invoke(Question $question)
    {
        if (!Gate::allows('forceDelete', $question)) {
            abort(403);
        }

        $question->forceDelete();

        return response()->noContent();
    }

}
