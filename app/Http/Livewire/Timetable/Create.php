<?php

namespace App\Http\Livewire\Timetable;

use App\Models\TeacherSubject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $user;
    public $teacherSubjects;
    public $teacherClassrooms;
    public $classRooms;

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
        return view('livewire.timetable.create');
    }
}
