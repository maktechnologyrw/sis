<?php

namespace App\Tables;

use App\Models\AttendanceList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class AttendanceListsTable extends AbstractTable
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
        return (new Table())->model(AttendanceList::class)
            ->routes([
                'index'   => ['name' => 'attendance'],
                'create'  => ['name' => 'startAttendanceSession']
            ])
            ->destroyConfirmationHtmlAttributes(fn (AttendanceList $attendanceList) => [
                'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                    'entry' => $attendanceList->database_attribute,
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
        $table->column('id')->sortable();
        $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable();
        $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable(true, 'desc');
        $table->column()->title("Edit List")->html(fn (AttendanceList $list) => '<a class="btn btn-outline btn-primary" href="attendance/' . $list->id . '/students">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        <span>Edit list</span>
        </a>');
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
