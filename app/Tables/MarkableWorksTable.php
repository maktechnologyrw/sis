<?php

namespace App\Tables;

use App\Models\MarkableWork;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class MarkableWorksTable extends AbstractTable
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
        return (new Table())->model(MarkableWork::class)
            ->routes([
                'index'   => ['name' => 'marking'],
                'create'   => ['name' => 'startMarkingSession'],
            ])
            ->query(function (Builder $query) {
                $query->select("markable_works.*");
                $query->addSelect("school_class_subjects.name as subject_name");
                $query->addSelect("school_markables.name as markable_type");
                $query->addSelect("school_class_category_level_years.name as class_year");
                $query->join("school_class_subjects", "school_class_subjects.id", "=", "markable_works.subject_id");
                $query->join("school_markables", "school_markables.id", "=", "markable_works.markable_id");
                $query->join("school_class_category_level_years", "school_class_category_level_years.id" , "=", "school_class_subjects.class_id");
                $query->where("markable_works.teacher_id", "=", $this->user->schoolUser->model_id);
            })
            ->destroyConfirmationHtmlAttributes(fn (MarkableWork $markableWork) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $markableWork->database_attribute,
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
        $table->column('class_year')->searchable("school_class_category_level_years", ["name"])->title("Class")->sortable();
        $table->column("markable_type")->title("Type")->sortable()->searchable("school_markables", ["name"]);
        $table->column("subject_name")->title("Subject")->sortable()->searchable("school_class_subjects", ["name"]);
        $table->column('name')->searchable()->title("Name")->sortable();
        $table->column('done_on')->dateTimeFormat('d/m/Y')->sortable()->title("Done On")->searchable();
        $table->column()->title("Time")->html(fn (MarkableWork $markableWork) => $markableWork->started_at . ' - ' . $markableWork->ended_at);
        $table->column()->title("Edit Marks")->html(fn (MarkableWork $markableWork) => '<a class="btn btn-outline btn-primary" href="marking/' . $markableWork->id . '/students">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        <span>Edit Marks</span>
        </a>');
        // $table->column()->title("Number of Students")->html(fn)
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
