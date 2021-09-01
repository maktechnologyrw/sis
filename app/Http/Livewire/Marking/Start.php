<?php

namespace App\Http\Livewire\Marking;

use App\Models\AcademicYearTerm;
use App\Models\CurrentSchoolAcademicYear;
use App\Models\MarkableWork;
use App\Models\SchoolMarkable;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Start extends Component
{
    public $user;
    public $teacherSubjects;
    public $subject;
    public $academicTerms;
    public $currentAcademicYear;
    public $schoolMarkables;
    public $display_name;
    public $done_on;
    public $starts_at;
    public $ends_at;
    public $term;
    public $markable;
    public $max_points;

    public function render()
    {
        return view('livewire.marking.start');
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->teacherSubjects = TeacherSubject::where("school_id", "=", $this->user->schoolUser->school_id)->where("teacher_id", "=", $this->user->schoolUser->model_id)->get();
        $this->currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->academicTerms = AcademicYearTerm::where("academic_year_id", "=", $this->currentAcademicYear[0]->year_id)->get();
        $this->schoolMarkables = SchoolMarkable::where("school_id", "=", $this->user->schoolUser->school_id)->get();
    }

    public function startSession() {
        $schoolMarkable = SchoolMarkable::find($this->markable);
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $markableWork = new MarkableWork;

        $markableWork->school_id = $this->user->schoolUser->school_id;
        $markableWork->academic_year_id = $currentAcademicYear[0]->year_id;
        $markableWork->markable_id = $this->markable;
        $markableWork->teacher_id = $this->user->schoolUser->model_id;
        $markableWork->term_id = $this->term;
        $markableWork->subject_id = $this->subject;
        $markableWork->name = $this->display_name;
        $markableWork->done_on = $this->done_on;
        $markableWork->started_at = $this->starts_at;
        $markableWork->ended_at = $this->ends_at;
        $markableWork->is_report_candidate = $schoolMarkable->is_report_candidate;
        $markableWork->maximum_points = $this->max_points;

        $markableWork->save();

        redirect("/marking/$markableWork->id/students", ["id" => $markableWork->id]);
    }
}
