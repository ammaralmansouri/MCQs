<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //

    protected $fillable = [
        'user_test_id',
        'question_id',
        'choice_id',
        'is_correct',
    ];
}
