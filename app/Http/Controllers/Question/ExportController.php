<?php

namespace App\Http\Controllers\Question;

use App\Exports\QuestionsExport;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function __invoke()
    {
        return (new QuestionsExport())->download('questions.xlsx');
    }
}
