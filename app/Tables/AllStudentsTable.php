<?php

namespace App\Tables;

use App\Models\CurrentSchoolAcademicYear;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class AllStudentsTable extends AbstractTable
{
    public User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        $table = new Table();
        return ($table)->model(Student::class)
            ->routes([
                'index'   => ['name' => 'students'],
                'create'   => ['name' => 'addStudent'],
                'edit'   => ['name' => 'updateStudent', "params" => ["id" => $table->getModel()->id]],
                'show'   => ['name' => 'updateStudent', "params" => ["id" => $table->getModel()->id]],
                'destroy'   => ['name' => 'disableStudent', "params" => ["id" => $table->getModel()->id]]
            ])
            ->query(function (Builder $query) {
                $query->select("students.*");
                $query->leftJoin("student_registrations", "student_registrations.student_id", "=", "students.id");
                $query->leftJoin("enrollments", "enrollments.registration_id", "=", "student_registrations.student_id");
                // $query->where("student_registrations.school_id", $this->user->schoolUser->school_id);

                $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

                // $query->where("student_registrations.year_id", $currentAcademicYear[0]->year_id);
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
            ->tbodyTemplate("templates.tailwindcss.tbody");
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
        $table->column("first_name")->title("First Name")->sortable()->searchable();
        $table->column("last_name")->title("Last Name")->sortable()->searchable();
        $table->column("sex")->title("Sex")->sortable()->searchable();
        $table->column("date_of_birth")->title("Date of Birth")->sortable()->searchable();
        $table->column()->title("Registered")->html(function (Student $student) {
            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
            $registrations = $student->registrations()->where("school_id", $this->user->schoolUser->school_id)->where("year_id", $currentAcademicYear[0]->year_id)->get();

            $string = '
                <div class="badge badge-warning py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                N/A
            </div>';

            if (count($registrations) > 0) {
                $string = '
                <div class="badge badge-success py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    ' . $registrations[0]->schoolClassCategoryLevelYear->name . '
                </div>';
            }

            return $string;
        });
        $table->column()->title("Admitted")->html(function (Student $student) {
            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
            $registrations = $student->registrations()->where("school_id", $this->user->schoolUser->school_id)->where("year_id", $currentAcademicYear[0]->year_id)->get();

            $string = '
                <div class="badge badge-warning py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                N/A
            </div>';

            if (count($registrations) > 0 && isset($registrations[0]->enrollment) && isset($registrations[0]->enrollment->id)) {
                $string = '
                <div class="badge badge-success py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    ' . $registrations[0]->enrollment->classRoom->name . '
                </div>';
            }

            return $string;
        });
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
