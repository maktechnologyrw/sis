<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    /* protected $dispatchesEvents = [
        'saved' => UserSaved::class,
        'deleted' => UserDeleted::class,
    ]; */

    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $query) {
            $query->where('students.enabled', 1);
        });
    }

    public function registrations()
    {
        return $this->hasMany(StudentRegistration::class);
    }

    public function parents() {
        return $this->hasManyThrough(ParentingPerson::class, StudentParent::class, 'student_id', "id");
    }
}
