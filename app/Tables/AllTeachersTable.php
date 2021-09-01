<?php

namespace App\Tables;

use App\Models\CurrentSchoolAcademicYear;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class AllTeachersTable extends AbstractTable
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
        return ($table)->model(Teacher::class)
            ->routes([
                'index'   => ['name' => 'teachers'],
                'create'   => ['name' => 'addTeacher'],
                'edit'   => ['name' => 'updateTeacher', "params" => ["id" => $table->getModel()->id]]
            ])
            ->query(function (Builder $query) {
                $query->addSelect("teachers.*");
                $query->join("school_teachers", "school_teachers.teacher_id", "=", "teachers.id");
                $query->where("school_teachers.school_id", $this->user->schoolUser->school_id);

                $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

                $query->where("school_teachers.academic_year_id", $currentAcademicYear[0]->year_id);
            })
            ->destroyConfirmationHtmlAttributes(fn (Teacher $teacher) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $teacher->database_attribute,
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
