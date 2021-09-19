<?php

namespace App\Http\Controllers;

use App\Tables\AttendanceListsTable;
use App\Tables\StudentsAttendanceTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AttendanceController extends Controller
{
    public function index()
    {
        $table = (new AttendanceListsTable())->setup();
        return view("attendance.index", compact('table'));
    }

    public function showStudents()
    {
        $table = (new StudentsAttendanceTable(Route::current()->parameters["id"]))->setup();
        return view("attendance.students", compact('table'));
    }
}
