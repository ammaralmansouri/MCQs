<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    //
    protected $fillable = [
        'choice_text',
        'is_correct',
        'question_id'
    ];

    public function question(){
        return $this->belongsTo(Question::class , 'question_id' , 'id');
    }

    public function results(){
        return $this->hasMany(Result::class , 'choice_id' , 'id');
    }
}
