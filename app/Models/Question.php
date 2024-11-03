<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    protected $hidden = [
        'user_id',
    ];

    //    protected $casts = [
    //        'created_at' => 'datetime:Y-m-d',
    //        'updated_at' => 'datetime:Y-m-d',
    //    ];
}
