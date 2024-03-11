<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'firstname',
        'middlename',
        'lastname',
        'course',
        'user_id',
        'level',
        'pic',
        'branch',
        'session_time',
        'session',
        'coach_name',
        'age',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coaches()
    {
        return $this->belongsToMany(Coach::class, 'coach_student', 'student_id', 'coach_id');
    }



}
