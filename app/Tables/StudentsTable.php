<?php

namespace App\Tables;

use App\Models\CurrentSchoolAcademicYear;
use App\Models\Mark;
use App\Models\MarkableWork;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class StudentsTable extends AbstractTable
{
    public User $user;
    public $id;

    // protected Request $request;
    protected $markableWork;

    public function __construct($id)
    {
        $this->user = Auth::user();
        // $this->request = $request;
        $this->id = $id;
        $this->markableWork = MarkableWork::find($id);
    }
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        // $this->markableWork = MarkableWork::where("id", "=", $this->request->input("id"))->get();
        return (new Table())->model(Student::class)
            ->routes([
                'index'   => ['name' => 'students']
            ])
            ->query(function (Builder $query) {
                $query->select("students.*");
                $query->join("student_registrations", "student_registrations.student_id", "=", "students.id");
                $query->join("enrollments", "enrollments.registration_id", "=", "student_registrations.student_id");
                $query->where("student_registrations.class_year_id", "=", $this->markableWork->schoolClassSubject->class_id);
            })
            ->destroyConfirmationHtmlAttributes(fn (Student $student) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $student->database_attribute,
                ]),
            ])
            ->tableTemplate('templates.tailwindcss.table')
            ->theadTemplate('templates.tailwindcss.thead')
            ->rowsSearchingTemplate('templates.tailwindcss.rows-searching')
            ->rowsNumberDefinitionTemplate('templates.tailwindcss.rows-number-definition')
            ->createActionTemplate("templates.tailwindcss.create-action")
            ->columnTitlesTemplate("templates.tailwindcss.column-titles")
            ->tbodyTemplate("templates.tailwindcss.students.tbody");
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('id')->sortable()->title("N&deg;");
        $table->column("first_name")->searchable()->title("First Name")->sortable();
        $table->column("last_name")->searchable()->title("Last Name")->sortable();
        $table->column("sex")->searchable()->title("Sex")->sortable();
        $table->column()->title("Status")->html(function (Student $student) {
            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
            $registration = $student->registrations()->where("year_id", "=", $currentAcademicYear[0]->year_id)->first();
            $enrollment = $registration->enrollment;
            $marks = Mark::where("work_id", "=", $this->id)->where("enrollment_id", "=", $enrollment->id)->get();
            $isMarked = count($marks) > 0;
            $badgeClass = "";
            $badgeText = "";
            $badgeIcon = "";
            switch ($isMarked) {
                case true:
                    $badgeClass = "badge-success";
                    $badgeText = "Saved";
                    $badgeIcon = config("laravel-table.icon.validate");
                    break;

                default:
                    $badgeClass = "badge-neutral";
                    $badgeText = "Not Marked";
                    $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-4 h-4 mr-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>';
                    break;
            }
            return '<div class="badge '.$badgeClass.'">'.$badgeIcon.$badgeText.'</div> ';
        });
        $table->column()->title("Marks")->html(fn (Student $student) => '<div class="form-control">
        <div class="relative">
          <input placeholder="ex: 10" class="pr-16 input md:w-full input-bordered" wire:model="marks">
          <button class="absolute top-0 right-0 rounded-l-none btn btn-outline btn-primary" wire:click="saveMarks(' . $student->id . ')"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg></button>
        </div>
      </div>');
        /* $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable();
        $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable(true, 'desc'); */
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
