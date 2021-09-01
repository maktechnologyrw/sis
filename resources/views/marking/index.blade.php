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
            Marking
        </h2>

        @if ($table->getPaginator()->isEmpty())
            <div class="w-full min-h-full px-10 py-36 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                @can('add marks to students')
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Start a <strong>Marking</strong> Session
                    </p>

                    <div>
                        <a href="{{ route('startMarkingSession') }}"
                            class="px-4 py-2 uppercase text-sm font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Start
                        </a>
                    </div>
                @endcan
            </div>
        @else
            {{ $table }}
        @endif
    </div>
</x-app-layout>
