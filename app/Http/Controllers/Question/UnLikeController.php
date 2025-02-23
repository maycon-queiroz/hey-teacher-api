<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Question $question)
    {
        user()->unlike($question);

        return response(status: Response::HTTP_CREATED);
    }
}
