@if ($table->isRouteDefined('create'))
    {{-- <a href="{{ $table->getRoute('create') }}" title="@lang('Create')"
        class="flex uppercase items-center justify-between px-5 py-3 font-medium leading-5 text-sm text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        {!! config('laravel-table.icon.create') !!}
        <span>@lang('Create')</span>
    </a> --}}
    <a class="btn btn-primary" href="{{ $table->getRoute('create') }}" title="@lang('Create')">
        {!! config('laravel-table.icon.create') !!}
        <span>@lang('Create')</span>
    </a>
@endif
