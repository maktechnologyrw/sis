<div class="flex flex-col">
    {{-- {{ json_encode($this->teacherClassrooms) }} --}}
    {{-- <ul>
        @foreach ($this->teacherSubjects as $subject)
            <li>{{ $loop->index }} {{ $subject->schoolClassSubject->schoolClassCategoryLevelYear->classRooms[0] }}</li>
        @endforeach
    </ul> --}}

    {{-- Start and End Time --}}
    <div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
            <x-daisy.input label="Start Time" type="time" wire:model="times.start" />
            <x-daisy.input label="End Time" type="time" wire:model="times.end" />
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="saveStartAndEndTimes()" wire:loading.class="loading disabled">
                Save
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Break Settings --}}
    {{-- Break Category Start and End Time --}}
    <div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="text-right">
            <button type="button" class="btn btn-primary btn-outline" wire:click="incrementBreaks()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                Add Break / Lunch
            </button>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
            @for ($i = 0; $i < $this->breakCount; $i++)
                <div class="form-control col-span-2">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Category</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="breaks.{{ $i }}.category">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        <option>Break</option>
                        <option>Lunch</option>
                    </select>
                </div>
                <x-daisy.input label="Start Time" type="time" wire:model="breaks.{{ $i }}.times.start" />
                <x-daisy.input label="End Time" type="time" wire:model="breaks.{{ $i }}.times.end" />
            @endfor
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="saveBreaksAndLunches" wire:loading.class="loading disabled">
                Save
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>


    {{-- School Days Settings --}}
    {{-- Day name with a toggle --}}
    <div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid sm:grid-cols-1 md:grid-cols-1 gap-4">
            @foreach ($daysOfTheWeek as $day)
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="label-text dark:text-gray-400">{{ $day['day'] }}</span>
                        <input type="checkbox" checked class="toggle toggle-primary"
                            wire:model="daysOfTheWeek.{{ $loop->index }}.status">
                    </label>
                </div>
            @endforeach
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="saveSchoolDays" wire:loading.class="loading disabled">
                Save
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>


    {{-- Period Settings --}}
    {{-- Default period duration --}}
    <div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid sm:grid-cols-1 md:grid-cols-1 gap-4">
            <x-daisy.input label="Period Duration in Minutes" placeholder="Period Duration in Minutes" type="number"
                wire:model="defaultPeriodDuration" />
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="saveDefaultPeriodDuration"
                wire:loading.class="loading disabled">
                Save
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>


    {{-- Daily periods and breaks flow --}}
    <div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex justify-end">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-outline" wire:click="addBreakComponent()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Add Break / Lunch
                </button>
                <button type="button" class="btn btn-primary btn-outline" wire:click="addPeriodComponent()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Add Period
                </button>
            </div>
        </div>
        <div>
            @foreach ($this->componentArray as $component)
                @if ($component['type'] == 'P')
                    {{ $this->periodComponent($loop->index) }}
                @endif
                @if ($component['type'] == 'B')
                    {{ $this->breakComponent($loop->index) }}
                @endif
            @endforeach
            <div class="float-right my-4">
                <button class="btn btn-primary" wire:click="saveTimelineComponents"
                    wire:loading.class="loading disabled">
                    Save
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
