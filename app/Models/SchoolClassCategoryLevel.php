<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClassCategoryLevel extends Model
{
    use HasFactory;

    protected $fillable = ["school_id", "parent_id" , "class_category_id", "class_level_id"];
}
