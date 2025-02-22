<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $statusRequest = request()->status;
        Validator::validate(
            ['status' => $statusRequest],
            ['status' => ['required', 'in:draft,published,archived']]
        );

        $status = $this->status($statusRequest);

        if ($status !== 2) {
            $question = Question::query()
                ->whereUserId(auth()->id())
                ->where('status', $status)
                ->get();

            return QuestionResource::collection($question);
        }
    }

    private function status(string $statusRequest)
    {
        if ($statusRequest === 'archived') {
            return 2;
        }

        if ($statusRequest === 'published') {
            return 1;
        }

        return 0;
    }
}
