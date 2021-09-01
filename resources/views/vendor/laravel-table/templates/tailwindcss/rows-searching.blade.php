@if ($table->getSearchableColumns()->count())
    <form role="form" method="GET" action="{{ $table->getRoute('index') }}">
        <input type="hidden" name="{{ $table->getRowsNumberField() }}"
            value="{{ $table->getRequest()->get($table->getRowsNumberField()) }}">
        <input type="hidden" name="{{ $table->getSortByField() }}"
            value="{{ $table->getRequest()->get($table->getSortByField()) }}">
        <input type="hidden" name="{{ $table->getSortDirField() }}"
            value="{{ $table->getRequest()->get($table->getSortDirField()) }}">
        @foreach ($table->getGeneratedHiddenFields() as $appendedKey => $appendedValue)
            <input type="hidden" name="{{ $appendedKey }}" value="{{ $appendedValue }}">
        @endforeach
        <div class="form-control">
            <div class="relative">
                <button class="absolute top-0 left-0 rounded-r-none btn btn-disabled dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">{!! config('laravel-table.icon.search') !!}</button>
                <input class="w-full pr-16 pl-16 input input-bordered dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    name="{{ $table->getSearchField() }}"
                    value="{{ $table->getRequest()->get($table->getSearchField()) }}"
                    placeholder="@lang('Search by:') {{ $table->getSearchableTitles() }}"
                    aria-label="@lang('Search by:') {{ $table->getSearchableTitles() }}" />
                @if ($table->getRequest()->get($table->getSearchField()))
                    <a class="absolute top-0 right-0 rounded-l-none btn btn-outline"
                        href="{{ $table->getRoute(
    'index',
    array_merge(
        [
            $table->getSearchField() => null,
            $table->getRowsNumberField() => $table->getRequest()->get($table->getRowsNumberField()),
            $table->getSortByField() => $table->getRequest()->get($table->getSortByField()),
            $table->getSortDirField() => $table->getRequest()->get($table->getSortDirField()),
        ],
        $table->getAppendedToPaginator(),
    ),
) }}"
                        title="@lang('Reset research')">
                        <span>{!! config('laravel-table.icon.reset') !!}</span>
                    </a>
                @else
                    <button
                        class="absolute top-0 right-0 rounded-l-none btn btn-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">{!! config('laravel-table.icon.validate') !!}</button>
                @endif
            </div>
        </div>
    </form>
@endif
