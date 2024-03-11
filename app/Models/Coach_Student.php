<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach_Student extends Model
{
    use HasFactory;

    public function coaches() {
        return $this->hasOne(Coach::class);
    }

}
