<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'age',
        'pic',
        'session_time',
        'email',
        'password',
        'course',
        'level',
        'branch',
        'phone',
        'coach_id',
        'date_reserved',
        'userType',
        'status'

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->date_reserved = now();
        });

        static::saved(function ($user) {
            // Check if the user is being updated and has a coach_id
            if ($user->isDirty('coach_id') && $user->userType === 'student') {
                // Get the coach
                $coach = $user->coach;

                // If coach exists, add the student to the coach's students list
                if ($coach) {
                    $coach->students()->save($user);
                }
            }
        });
    


    }

    public function students() {
        return $this->hasOne(Student::class);
    }

    public function coaches() {
        return $this->hasOne(Coach::class);
    }

    protected $table = 'users';

    // Define the relationship for a coach and their students
    public function student()
    {
        return $this->hasMany(User::class, 'coach_id');
    }

    // Define the relationship for a student and their coach
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
