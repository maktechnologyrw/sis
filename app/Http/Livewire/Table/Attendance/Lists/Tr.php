<?php

namespace App\Http\Livewire\Table\Attendance\Lists;

use App\Models\Attendance;
use App\Models\AttendanceList;
use App\Models\CurrentSchoolAcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Tr extends Component
{
    public $model;
    // public $status;
    public $identifier;
    public $user;
    public $successMsg;
    public $attendanceList;
    public $attendance;

    public function mount()
    {
        $this->user = Auth::user();
        $this->identifier = Route::current()->parameters["id"];
        $this->attendanceList = AttendanceList::find($this->identifier);
        $this->attendance = $this->attendanceList->attendances->where('enrollment_id', $this->model->registrations->last()->enrollment->id)->first();
        $this->successMsg = $this->attendance;
        // $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        // $this->successMsg = $this->model->registrations->first()->enrollment;
    }

    public function render()
    {
        return view('livewire.table.attendance.lists.tr', ["identifier" => $this->identifier, "model" => $this->model]);
    }

    public function saveAttendance($status)
    {
        if ($this->attendance) {
            $this->attendance->attended = $status;

            $this->attendance->save();
        } else {
            $this->attendance = new Attendance;

            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

            $this->attendance->school_id = $this->user->schoolUser->school_id;
            $this->attendance->year_id = $currentAcademicYear[0]->year_id;
            $this->attendance->list_id = $this->identifier;
            $this->attendance->enrollment_id = $this->model->registrations->last()->enrollment->id;
            $this->attendance->attended = $status;

            $this->attendance->save();
        }
    }

    public function updateAttendance()
    {
        //
    }

    public function markAsNotAttended()
    {
        $this->saveAttendance(false);
    }

    public function markAsAttended()
    {
        $this->saveAttendance(true);
    }
}
