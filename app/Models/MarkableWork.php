<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkableWork extends Model
{
    use HasFactory;

    public function schoolClassSubject() {
        return $this->belongsTo(SchoolClassSubject::class, "subject_id");
    }
}
