<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    use HasFactory;

    public function enrollment() {
        return $this->hasOne(Enrollment::class, 'registration_id');
    }

    public function schoolClassCategoryLevelYear()
    {
        return $this->belongsTo(SchoolClassCategoryLevelYear::class, "class_year_id");
    }
}
