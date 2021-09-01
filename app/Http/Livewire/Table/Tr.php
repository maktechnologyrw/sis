<?php

namespace App\Http\Livewire\Table;

use App\Models\CurrentSchoolAcademicYear;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use App\Tables\StudentsTable;
use Illuminate\Support\Facades\Auth;

class Tr extends Component
{
    public $identifier;
    public $model;
    public $marks;
    public $user;

    public function render()
    {
        return view('livewire.table.tr', ["identifier" => $this->identifier, "model" => $this->model]);
    }

    public function mount() {
        $this->identifier = Route::current()->parameters["id"];
        $this->user = Auth::user();
        $student = Student::find($this->model->id);
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $registration = $student->registrations()->where("year_id", "=", $currentAcademicYear[0]->year_id)->first();
        $enrollment = $registration->enrollment;
        $marks = Mark::where("work_id", "=", $this->identifier)->where("enrollment_id", "=", $enrollment->id)->get();
        // $this->marks = count($marks) > 0 ? $marks[0] : 0;
        $this->marks = count($marks) > 0 ? $marks[0]->marks : 0;
    }

    public function saveMarks($studentId) {
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $student = Student::find($studentId);
        $registration = $student->registrations()->where("year_id", "=", $currentAcademicYear[0]->year_id)->first();
        $enrollment = $registration->enrollment;

        $points = new Mark;

        $points->school_id = $this->user->schoolUser->school_id;
        $points->academic_year_id = $currentAcademicYear[0]->year_id;
        $points->work_id = $this->identifier;
        $points->enrollment_id = $enrollment->id;
        $points->marks = $this->marks;

        $points->save();
    }
}
