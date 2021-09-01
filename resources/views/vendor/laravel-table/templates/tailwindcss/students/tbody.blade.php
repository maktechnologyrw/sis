<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    @if($table->getPaginator()->isEmpty())
        <tr {{ html_classes($table->getTrClasses()) }}>
            <td {{ html_classes($table->getTdClasses(), 'text-center', 'px-3') }}{{ html_attributes($table->getColumnsCount() > 1 ? ['colspan' => $table->getColumnsCount()] : null) }} scope="row">
                <span class="text-info">
                    {!! config('laravel-table.icon.info') !!}
                </span>
                @lang('No results were found.')
            </td>
        </tr>
    @else
        @foreach($table->getPaginator() as $model)
            @livewire('table.tr', ['model' => $model], key($model->id))
        @endforeach
        @include('laravel-table::' . $table->getResultsTemplatePath())
    @endif
</tbody>


