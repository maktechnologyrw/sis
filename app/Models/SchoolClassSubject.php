<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassSubject extends Model
{
    use HasFactory;

    public function schoolClassCategoryLevelYear()
    {
        return $this->belongsTo(SchoolClassCategoryLevelYear::class, "class_id");
    }
}
