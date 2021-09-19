@props(['disabled' => false, 'label' => ''])

<div class="form-control">
    <label class="label">
        <span class="label-text dark:text-gray-300">{{ $label }}</span>
    </label>
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'input input-bordered shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-gray']) !!}>
</div>
