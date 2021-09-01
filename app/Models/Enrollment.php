<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    public function registration() {
        return $this->belongsTo(StudentRegistration::class, "registration_id");
    }

    public function classRoom(){
        return $this->belongsTo(SchoolClassRoom::class, "room_id");
    }
}
