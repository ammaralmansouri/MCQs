<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    //
    protected $table = 'user_test'; // Make Laravel use the correct table name

    protected $fillable = [
        'score',
        'number_of_total_questions',
        'number_of_answred_questions',
        'number_of_correct_answers',
        'taken_time_to_complete_the_test',
        'user_id',
        'test_id',
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'user_test_id', 'id');
    }
}
