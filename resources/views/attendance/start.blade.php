<x-app-layout title="Dashboard">
    <div class="container grid md:px-6 mx-auto">
        {{-- <ul class="w-full steps dark:text-gray-200" data-theme="cupcake">
            <li class="step step-info">Fly to moon</li>
            <li class="step step-info">Shrink the moon</li>
            <li class="step step-info">Grab the moon</li>
            <li data-content="?" class="step step-error">Sit on toilet</li>
          </ul> --}}
        {{-- @livewire('wizard.registration') --}}
        <h2 class="my-6 px-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Start Attendance Session
        </h2>
        @livewire('attendance.start')
    </div>
</x-app-layout>
