<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Tables\AllTeachersTable;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index() {
        $table = (new AllTeachersTable())->setup();
        return view("teachers.index", compact('table'));
    }

    public function edit() {
        return view("teachers.update");
    }

    public function disable($id) {
        $teacher = Teacher::find($id);

        $teacher->enabled = 0;

        $teacher->save();

        return redirect('teachers');
    }
}
