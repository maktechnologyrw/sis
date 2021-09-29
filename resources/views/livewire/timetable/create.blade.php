<div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    {{ json_encode($this->teacherClassrooms) }}
    {{-- <ul>
        @foreach ($this->teacherSubjects as $subject)
            <li>{{ $loop->index }} {{ $subject->schoolClassSubject->schoolClassCategoryLevelYear->classRooms[0] }}</li>
        @endforeach
    </ul> --}}
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text dark:text-gray-300">Choose Class Room</span>
            </label>
            <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                wire:model="room">
                <option disabled="disabled" selected="selected" value="">Choose Class Room</option>
                <option value=""></option>
                {{-- @foreach ($teacherClassrooms as $classRoom)
                    <option value="{{ $classRoom['id'] }}">{{ $classRoom['name'] }}</option>
                @endforeach --}}
            </select>
        </div>
        <x-daisy.input label="Attendace Date" wire:model="date" type="date" />
    </div>
    <div class="float-right my-4">
        <button class="btn btn-primary" wire:click="startSession" wire:loading.class="loading disabled">
            Start Attendance Session
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
