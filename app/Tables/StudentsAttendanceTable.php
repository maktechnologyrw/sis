<?php

namespace App\Tables;

use App\Models\AttendanceList;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class StudentsAttendanceTable extends AbstractTable
{
    public User $user;
    public $identifier;
    public $attendanceList;

    public function __construct($id)
    {
        $this->user = Auth::user();
        $this->identifier = $id;
        $this->attendanceList = AttendanceList::find($this->identifier);
    }

    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Student::class)
            ->routes([
                'index'   => ['name' => 'attendance'],
                'create'  => ['name' => 'startAttendanceSession']
            ])
            ->query(function (Builder $query) {
                $query->select("students.*");
                $query->join("student_registrations", "student_registrations.student_id", "=", "students.id");
                $query->join("enrollments", "enrollments.registration_id", "=", "student_registrations.student_id");
                // $query->where("student_registrations.class_year_id", "=", $this->markableWork->schoolClassSubject->class_id);
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
            ->tbodyTemplate("templates.tailwindcss.attendance.lists.tbody");
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
        $table->column()->title("Has Attended")->html(
            function (Student $student) {
                $attendance = $this->attendanceList->attendances->where('enrollment_id', $student->registrations->last()->enrollment->id)->first();
                $yesActive = $noActive = '';
                if ($attendance) {
                    if ($attendance->attended) {
                        $yesActive = "btn-active";
                    } else {
                        $noActive = "btn-active";
                    }
                }
                return '
                <div class="btn-group">
                    <button class="btn btn-secondary btn-outline ' . $noActive . '" wire:click="markAsNotAttended"
                        wire:loading.class="loading disabled">
                        No
                    </button>
                    <button class="btn btn-primary btn-outline ' . $yesActive . '" wire:click="markAsAttended" wire:loading.class="loading disabled">
                        Yes
                    </button>
                </div>
                ';
            }
        );
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
