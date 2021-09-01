<?php

namespace App\Http\Controllers;

use App\Models\MarkableWork;
use App\Tables\MarkableWorksTable;
use App\Tables\StudentsTable;
use Illuminate\Http\Request;

class MarkingController extends Controller
{
    protected Request $request;
    protected $markableWork;

    public function addMarks(Request $request, $id)
    {
        $markableWork = MarkableWork::find($id);
        $table = (new StudentsTable($id))->setup();
        return view("marking.students", compact('table', 'id', 'markableWork'));
    }

    public function index()
    {
        $table = (new MarkableWorksTable())->setup();
        return view("marking.index", compact('table'));
    }
}
