<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    {{-- {{json_encode($this->teacherSubjects)}} --}}
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        <label class="block text-sm mt-3">
            <span class="text-gray-700 dark:text-gray-400">
                Subjects
            </span>
            <select
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                wire:model="subject">
                <option value=""></option>
                @foreach ($this->teacherSubjects as $subject)x
                    <option value="{{ $subject['subject_id'] }}">{{ $subject['name'] }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm mt-3">
            <span class="text-gray-700 dark:text-gray-400">
                Term
            </span>
            <select
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                wire:model="term">
                <option value=""></option>
                @foreach ($this->academicTerms as $academicTerm)
                    <option value="{{ $academicTerm['id'] }}">Term {{ $academicTerm['number'] }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm mt-3">
            <span class="text-gray-700 dark:text-gray-400">
                Type
            </span>
            <select
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                wire:model="markable">
                <option value=""></option>
                @foreach ($this->schoolMarkables as $schoolMarkable)
                    <option value="{{ $schoolMarkable['id'] }}">{{ $schoolMarkable['name'] }}</option>
                @endforeach
            </select>
        </label>
        <x-daisy.input label="Display Name" wire:model="display_name" />
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        <x-daisy.input label="Threshhold / Maximum Points" type="number" wire:model="max_points" />
        <x-daisy.input label="Done on" type="date" wire:model="done_on" />
        <x-daisy.input label="Starts At" type="time" wire:model="starts_at" />
        <x-daisy.input label="Ends At" type="time" wire:model="ends_at" />
    </div>
    <div class="float-right my-4">
        <button
            class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            wire:click="startSession" type="button">
            Next
        </button>
    </div>
</div>
