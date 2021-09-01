<div class="w-full bg-white overflow-hidden rounded-lg shadow-xs">
    <div {{ html_classes('table-container', $table->getContainerClasses()) }}>
        <table {{ html_attributes($table->getIdentifier() ? ['id' => $table->getIdentifier()] : null) }}
            {{ html_classes($table->getTableClasses()) }}>
            @include('laravel-table::' . $table->getTheadTemplatePath())
            @include('laravel-table::' . $table->getTbodyTemplatePath())
            @include('laravel-table::' . $table->getTfootTemplatePath())
        </table>
    </div>
</div>
