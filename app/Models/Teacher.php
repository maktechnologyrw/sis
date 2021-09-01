<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $query) {
            $query->where('teachers.enabled', 1);
        });
    }
}
