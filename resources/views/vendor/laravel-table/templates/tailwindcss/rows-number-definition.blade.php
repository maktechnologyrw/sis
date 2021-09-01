@if ($table->getRowsNumberDefinitionActivation())
    <form role="form" method="GET" action="{{ $table->getRoute('index') }}">
        <input type="hidden" name="{{ $table->getSearchField() }}"
            value="{{ $table->getRequest()->get($table->getSearchField()) }}" />
        <input type="hidden" name="{{ $table->getSortByField() }}"
            value="{{ $table->getRequest()->get($table->getSortByField()) }}" />
        <input type="hidden" name="{{ $table->getSortDirField() }}"
            value="{{ $table->getRequest()->get($table->getSortDirField()) }}" />
        @foreach ($table->getGeneratedHiddenFields() as $appendedKey => $appendedValue)
            <input type="hidden" name="{{ $appendedKey }}" value="{{ $appendedValue }}" />
        @endforeach
        <div class="form-control">
            <div class="relative">
                <button class="absolute top-0 left-0 rounded-r-none btn btn-disabled dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">{!! config('laravel-table.icon.rows_number') !!}</button>
                <input class="w-full pr-16 pl-16 input input-bordered dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" type="number"
                    name="{{ $table->getRowsNumberField() }}"
                    value="{{ $table->getRequest()->get($table->getRowsNumberField()) }}"
                    placeholder="@lang('Number of rows')" aria-label="@lang('Number of rows')" />
                <button class="absolute top-0 right-0 rounded-l-none btn btn-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">{!! config('laravel-table.icon.validate') !!}</button>
            </div>
        </div>
    </form>
@endif
