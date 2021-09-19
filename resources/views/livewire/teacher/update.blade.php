<div class="grid grid-cols-1">
    <div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
        <div>
            {{-- @include('noty::message') --}}
        </div>
        <div>
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                <x-daisy.input label="First Name" placeholder="Jane" wire:model="teacher.names.first" />
                <x-daisy.input label="Last Name" placeholder="Doe" wire:model="teacher.names.last" />
                @php
                    $data = [['id' => 'Male', 'name' => 'Male'], ['id' => 'Female', 'name' => 'Female']];
                @endphp
                <x-select :data="$data" empty-message='No sexes match your search.' name='sex'
                    placeholder='Choose a sex' key-index="id" value-index="name" wire-bound-by='teacher.sex'
                    label="Choose Sex" />
                <x-daisy.input label="Email" placeholder="example@domain.com" wire:model="teacher.email" type="email" />
                @php
                    $data = [['id' => 'Below A2', 'name' => 'Below A2'], ['id' => 'A2', 'name' => 'A2'], ['id' => 'A1', 'name' => 'A1'], ['id' => 'A0', 'name' => 'A0'], ['id' => "Master's Degree", 'name' => "Master's Degree"], ['id' => 'PhD', 'name' => 'PhD'], ['id' => 'Professor', 'name' => 'Professor']];
                @endphp
                <x-select :data="$data" empty-message='No degrees match your search.' name='degree'
                    placeholder='Choose a degree' key-index="id" value-index="name" wire-bound-by='teacher.degree'
                    label="Choose Degree" />
                <x-daisy.input label="Qualification" wire:model="teacher.qualification" />
                <x-select :data='$countries' empty-message='No countries match your search.' name='country'
                    placeholder='Select a country' key-index="id" value-index="nicename"
                    wire-bound-by='teacher.birth.country' label="Choose Birth Country" />
                <x-select :data='$countries' empty-message='No countries match your search.' name='country'
                    placeholder='Select a country' key-index="id" value-index="nicename"
                    wire-bound-by='teacher.residential.country' label="Choose Residential Country" />
            </div>
            <div class="grid md:grid-cols-1 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                <label
                    class="flex flex-col px-4 py-3 bg-white text-gray-500 rounded-lg tracking-wide uppercase border border-dashed border-blue cursor-pointer hover:bg-blue hover:text-white dark:text-gray-400 dark:border-gray-600 dark:bg-gray-700">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="text-muted text-center text-gray-500">Select a file</span>
                    </div>
                    <input type='file' class="hidden" wire:model="profilePicure" />
                </label>
            </div>
            <div class="float-right my-4">
                <button class="btn btn-primary" wire:click="firstStepSubmit" wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                    </svg>
                    Save
                </button>
            </div>
        </div>
    </div>
    <div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Province</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.province" wire:change="setDistricts()">
                    <option disabled="disabled" selected="selected">Choose Province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province['provincecode'] }}">{{ $province['provincename'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose District</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.district" wire:change="setSectors()">
                    <option disabled="disabled" selected="selected">Choose District</option>
                    @foreach ($birthDistricts as $district)
                        <option value="{{ $district['DistrictCode'] }}">{{ $district['DistrictName'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Sector</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.sector" wire:change="setCells()">
                    <option disabled="disabled" selected="selected">Choose Sector</option>
                    @foreach ($birthSectors as $sector)
                        <option value="{{ $sector['SectorCode'] }}">{{ $sector['SectorName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Cell</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.cell" wire:change="setVillages()">
                    <option disabled="disabled" selected="selected">Choose Cell</option>
                    @foreach ($birthCells as $cell)
                        <option value="{{ $cell['CellCode'] }}">{{ $cell['CellName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Village</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.village">
                    <option disabled="disabled" selected="selected">Choose Village</option>
                    @foreach ($birthVillages as $village)
                        <option value="{{ $village['VillageCode'] }}">{{ $village['VillageName'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="secondStepSubmit" wire:loading.class="loading disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
    <div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Province</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.province" wire:init="loadProvinces"
                    wire:change="setDistricts('residential')">
                    <option disabled="disabled" selected="selected">Choose Province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province['provincecode'] }}">{{ $province['provincename'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose District</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.district" wire:change="setSectors('residential')">
                    <option disabled="disabled" selected="selected">Choose District</option>
                    @foreach ($residentialDistricts as $district)
                        <option value="{{ $district['DistrictCode'] }}">{{ $district['DistrictName'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Sector</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.sector" wire:change="setCells('residential')">
                    <option disabled="disabled" selected="selected">Choose Sector</option>
                    @foreach ($residentialSectors as $sector)
                        <option value="{{ $sector['SectorCode'] }}">{{ $sector['SectorName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Cell</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.cell" wire:change="setVillages('residential')">
                    <option disabled="disabled" selected="selected">Choose Cell</option>
                    @foreach ($residentialCells as $cell)
                        <option value="{{ $cell['CellCode'] }}">{{ $cell['CellName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Village</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.village">
                    <option disabled="disabled" selected="selected">Choose Village</option>
                    @foreach ($residentialVillages as $village)
                        <option value="{{ $village['VillageCode'] }}">{{ $village['VillageName'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="thirdStepSubmit" wire:loading.class="loading disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
    <div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
        <div class="text-right">
            <button type="button" class="btn btn-primary btn-outline" wire:click="incrementSubjects()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                Add Subject
            </button>
        </div>
        <hr class="mt-4">
        <div>
            @if ($this->assignedSubjectsCount > 0)
                @for ($i = 0; $i < $this->assignedSubjectsCount; $i++)
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                        @if (isset($savedSchoolTeacherData->subjects[$i]))
                            <input label="First Name" placeholder="Jane" type="hidden"
                                wire:model="subjects.{{ $i }}.id" />
                        @endif
                        <x-select :data="$school_class_years" empty-message='No class match your search.' name='class'
                            placeholder='Choose a class' key-index="id" value-index="name"
                            wire-bound-by='subjects.{{ $i }}.year' label="Choose Class Year" />
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text dark:text-gray-300">School Class Subject</span>
                            </label>
                            <select
                                class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                wire:model="subjects.{{ $i }}.subject">
                                <option disabled="disabled" selected="selected">Select School Class Subject</option>
                                <option value=""></option>
                                @foreach ($this->schoolClassSubjects as $classSubject)
                                    @for ($u = 0; $u < count($this->subjects); $u++)
                                        @if ($i == $u)
                                            @isset($this->subjects[$i]['year'])
                                                {{-- {{ json_encode($classCategoryData) }} --}}
                                                @if ($classSubject->class_id == $this->subjects[$i]['year'])
                                                    <option value="{{ $classSubject->schoolClassSubject['id'] }}">
                                                        {{ $classSubject->schoolClassSubject['name'] }}</option>
                                                @endif
                                            @endisset
                                        @endif
                                    @endfor
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                @endfor
            @else
                @php
                    $i = 0;
                @endphp
                <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                    @if (isset($savedSchoolTeacherData->subjects[$i]))
                        <input label="First Name" placeholder="Jane" type="hidden"
                            wire:model="subjects.{{ $i }}.id" />
                    @endif
                    <x-select :data="$school_class_years" empty-message='No class match your search.' name='class'
                        placeholder='Choose a class' key-index="id" value-index="name"
                        wire-bound-by='subjects.{{ $i }}.year' label="Choose Class Year" />
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text dark:text-gray-300">School Class Subject</span>
                        </label>
                        <select
                            class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            wire:model="subjects.{{ $i }}.subject">
                            <option disabled="disabled" selected="selected">Select School Class Subject</option>
                            <option value=""></option>
                            @foreach ($this->schoolClassSubjects as $classSubject)
                                @for ($u = 0; $u < count($this->subjects); $u++)
                                    @if ($i == $u)
                                        @isset($this->subjects[$i]['year'])
                                            {{-- {{ json_encode($classCategoryData) }} --}}
                                            @if ($classSubject->class_id == $this->subjects[$i]['year'])
                                                <option value="{{ $classSubject->schoolClassSubject['id'] }}">
                                                    {{ $classSubject->schoolClassSubject['name'] }}</option>
                                            @endif
                                        @endisset
                                    @endif
                                @endfor
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
            @endif
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="fourthStepSubmit" wire:loading.class="loading disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
</div>
