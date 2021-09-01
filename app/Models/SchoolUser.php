<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function schoolTeacher() {
        return $this->belongsTo(SchoolTeacher::class, "model_id");
    }
}
