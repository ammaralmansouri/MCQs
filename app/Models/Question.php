<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'question_text',
        'question_media_url',
        'test_id',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id'); 
        // 'test_id' (foreign key in questions table), 'id' (primary key in tests table)
    }

    public function choices()
    {
        return $this->hasMany(Choice::class, 'question_id', 'id'); 
        // 'question_id' (foreign key in choices table), 'id' (primary key in questions table)
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'question_id', 'id'); 
        // 'question_id' (foreign key in results table), 'id' (primary key in questions table)
    }
}
