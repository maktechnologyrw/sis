<?php

namespace App\Http\Controllers;

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
}
