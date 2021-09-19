<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassCategoryLevelYear extends Model
{
    use HasFactory;

    protected $fillable = ["school_id", "parent_id", "level_id", "year_id"];

    public function schoolClassYear()
    {
        return $this->belongsTo(SchoolClassYear::class, "year_id");
    }

    public function classRooms()
    {
        return $this->hasMany(SchoolClassRoom::class, "year_id");
    }
}
