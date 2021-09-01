<div class="sm:grid md:flex gap-4 px-4 py-4 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
    <div class="flex-1">
        @if ($table->getSearchableColumns()->isNotEmpty())
            @include('laravel-table::' . $table->getRowsSearchingTemplatePath())
        @endif
    </div>
    <div class="flex-initial">
        @if ($table->getRowsNumberDefinitionActivation())
            @include('laravel-table::' . $table->getrowsNumberDefinitionTemplatePath())
        @endif
    </div>
    <div class="md:col-span-1">
        @include('laravel-table::' . $table->getCreateActionTemplatePath())
    </div>
</div>
<thead>
    @include('laravel-table::' . $table->getColumnTitlesTemplatePath())
</thead>
