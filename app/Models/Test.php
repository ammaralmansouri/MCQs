<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'test_id',
        'test_title',
        'test_description',
        'test_duration',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id', 'id');
        // 'test_id' (foreign key in questions table), 'id' (primary key in tests table)
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_test');
    }
}
