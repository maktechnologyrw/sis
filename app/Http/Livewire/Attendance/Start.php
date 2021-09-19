<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendanceList;
use App\Models\CurrentSchoolAcademicYear;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Start extends Component
{
    public $user;
    public $teacherSubjects;
    public $teacherClassrooms = [];

    public $room;
    public $date;

    public function mount()
    {
        $this->user = Auth::user();
        $this->teacherSubjects = TeacherSubject::where("school_id", "=", $this->user->schoolUser->school_id)->where("teacher_id", "=", $this->user->schoolUser->model_id)->get();

        foreach ($this->teacherSubjects as $subject) {
            foreach ($subject->schoolClassSubject->schoolClassCategoryLevelYear->classRooms as $classRoom) {
                // $this->teacherClassrooms[] = $classRoom;
                $inArray = false;
                foreach ($this->teacherClassrooms as $teacherClassroom) {
                    if ($teacherClassroom->name == $classRoom->name) {
                        $inArray = true;
                    }
                }

                if (!$inArray) {
                    $this->teacherClassrooms[] = $classRoom;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.attendance.start');
    }

    public function startSession() {
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

        $attendanceList = new AttendanceList;

        $attendanceList->school_id = $this->user->schoolUser->school_id;
        $attendanceList->year_id = $currentAcademicYear[0]->year_id;
        $attendanceList->room_id = $this->room;
        $attendanceList->teacher_id = $this->user->schoolUser->model_id;
        $attendanceList->date = $this->date;

        $attendanceList->save();

        redirect("/attendance/$attendanceList->id/students", ["id" => $attendanceList->id]);
    }
}
