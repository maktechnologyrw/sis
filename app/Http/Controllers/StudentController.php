<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Tables\AllStudentsTable;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $table = (new AllStudentsTable())->setup();
        return view("students.index", compact('table'));
    }

    public function edit() {
        return view("students.update");
    }

    public function disable($id) {
        $student = Student::find($id);

        $student->enabled = 0;

        $student->save();

        return redirect("students");
    }
}
