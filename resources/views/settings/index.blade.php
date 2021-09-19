<x-app-layout title="Dashboard">
    <div class="container grid px-6 mx-auto">
        {{-- <ul class="w-full steps dark:text-gray-200" data-theme="cupcake">
            <li class="step step-info">Fly to moon</li>
            <li class="step step-info">Shrink the moon</li>
            <li class="step step-info">Grab the moon</li>
            <li data-content="?" class="step step-error">Sit on toilet</li>
          </ul> --}}
        {{-- @livewire('wizard.registration') --}}
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Settings
        </h2>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <a href="{{ route('schoolInfoSettings') }}"
                            class="relative hover:bg-gray-200 dark:hover:bg-gray-900 p-4 rounded-lg">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900 dark:text-gray-400">School
                                    Info
                                </p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                School name, motto, date of establishment, location, class categories and class levels.
                            </dd>
                        </a>

                        <a href="{{ route('schoolTimetableSettings') }}"
                            class="relative hover:bg-gray-200 dark:hover:bg-gray-900 p-4 rounded-lg">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: outline/globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900 dark:text-gray-400">
                                    Timetable
                                </p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                School name, motto, date of establishment, location, class categories and class levels.
                            </dd>
                        </a>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
