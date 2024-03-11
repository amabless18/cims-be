<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
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
        'firstname',
        'middlename',
        'lastname',
        'pic',
        'level',
        'branch',
        'session_time',
        'session',
        'course',
        'age',
        'status',
        'date_reserved'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'coach_student', 'coach_id', 'student_id');
    }

}
