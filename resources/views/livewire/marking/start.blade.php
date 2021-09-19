<div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    {{-- {{ json_encode($this->schoolMarkables) }} --}}
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text dark:text-gray-300">Choose Subject</span>
            </label>
            <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                wire:model="subject">
                <option disabled="disabled" selected="selected" value="">Choose Subject</option>
                <option value=""></option>
                @foreach ($this->teacherSubjects as $subject)
                    <option value="{{ $subject['subject_id'] }}">{{ $subject['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text dark:text-gray-300">Choose Term</span>
            </label>
            <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                wire:model="term">
                <option disabled="disabled" selected="selected" value="">Choose Term</option>
                <option value=""></option>
                @foreach ($this->academicTerms as $academicTerm)
                    <option value="{{ $academicTerm['id'] }}">Term {{ $academicTerm['number'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text dark:text-gray-300">Choose Type</span>
            </label>
            <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                wire:model="markable">
                <option disabled="disabled" selected="selected" value="">Choose Type</option>
                <option value=""></option>
                @foreach ($this->schoolMarkables as $schoolMarkable)
                    <option value="{{ $schoolMarkable['id'] }}">{{ $schoolMarkable['name'] }}</option>
                @endforeach
            </select>
        </div>
        <x-daisy.input label="Display Name" wire:model="display_name" />
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 my-4">
        <x-daisy.input label="Threshhold / Maximum Points" type="number" wire:model="max_points" />
        <x-daisy.input label="Done on" type="date" wire:model="done_on" />
        <x-daisy.input label="Starts At" type="time" wire:model="starts_at" />
        <x-daisy.input label="Ends At" type="time" wire:model="ends_at" />
    </div>
    <div class="float-right my-4">
        <button class="btn btn-primary" wire:click="startSession" wire:loading.class="loading disabled">
            Start Marking Session
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
