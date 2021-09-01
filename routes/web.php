<?php

use App\Http\Controllers\MarkingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\SchoolUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    if (Auth::check()) {
        $userSchool = SchoolUser::where('user_id', '=', Auth::user()->id)->get();
        session(["school_id" => $userSchool[0]->id]);
    }
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');
    // Route::view('students', 'students.index')->name('students');
    Route::get("students", [StudentController::class, 'index'])->name('students');
    Route::view('students/add', 'students.create')->name('addStudent');
    Route::get("student/{id}/update", [StudentController::class, 'edit'])->name("updateStudent");
    Route::delete("student/{id}/disable", [StudentController::class, 'disable'])->name("disableStudent");
    // Route::view('teachers', 'teachers.index')->name('teachers');
    Route::get("teachers", [TeacherController::class, 'index'])->name('teachers');
    Route::view('teachers/add', 'teachers.create')->name('addTeacher');
    Route::get("teacher/{id}/update", [TeacherController::class, 'edit'])->name("updateTeacher");
    Route::delete("teacher/{id}/disable", [TeacherController::class, 'disable'])->name("disableTeacher");
    // Route::view('marking', 'marking.index')->name('marking');
    Route::get('marking', [MarkingController::class, 'index'])->name('marking');
    Route::view('marking/start', 'marking.start')->name('startMarkingSession');
    Route::get('marking/{id}/students', [MarkingController::class, 'addMarks']);
    // Route::view('marking/{id}/students', 'marking.students')->name('markingStudents');
});
