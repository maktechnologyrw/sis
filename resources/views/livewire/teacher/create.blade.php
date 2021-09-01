<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <ul class="w-full steps dark:text-gray-200" data-theme="cupcake">
        <li {{ $currentStep > 1 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep == 1 ? 'step-neutral' : 'step-success' }}">Teacher Info</li>
        <li {{ $currentStep > 2 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 2 ? 'step-neutral' : 'step-success' }}">Birth Address</li>
        <li {{ $currentStep > 3 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 3 ? 'step-neutral' : 'step-success' }}">Residential Address</li>
        <li {{ $currentStep > 4 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 4 ? 'step-neutral' : 'step-success' }}">Classes & Subjects</li>
        <li {{ $currentStep > 5 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 5 ? 'step-neutral' : 'step-success' }}">End</li>
    </ul>
    <div>
        {{-- {{ json_encode($currentAcademicYear) }} --}}
    </div>
    <div class="{{ $currentStep != 1 ? 'hidden' : '' }}">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6">
            <x-daisy.input label="First Name" placeholder="Jane" wire:model="teacher.names.first" />
            <x-daisy.input label="Last Name" placeholder="Doe" wire:model="teacher.names.last" />
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-x-6">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Sex</span>
                    </label>
                    <select
                        class="select select-ghost select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="teacher.sex">
                        <option disabled="disabled" selected="selected">Choose Sex</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <x-daisy.input label="Date of Birth" type="date" wire:model="teacher.date_of_birth" />
            </div>
            <x-daisy.input label="Email" placeholder="example@domain.com" wire:model="teacher.email" type="email" />
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Phone</span>
                </label>
                <div class="relative focus-within:shadow-outline-red">
                    <select wire:model="teacher.phone.country"
                        class="select w-1/6 select-bordered max-w-xs absolute top-0 left-0 rounded-r-none focus:shadow-outline-white dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 ">
                        <option disabled="disabled" selected="selected">Choose your country</option>
                        @foreach ($this->countries as $country)
                            @if ($country->id == 178)
                                <option value="{{ $country['id'] }}" selected>
                                    {{ $country['nicename'] }}</option>
                            @else
                                <option value="{{ $country['id'] }}">
                                    {{ $country['nicename'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="text" placeholder="788888888" wire:model="teacher.phone.number"
                        class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-cool-gray w-5/6 ml-1/6 rounded-l-none border-l-0 input input-bordered">
                </div>
            </div>
            <div class="form-control md:mt-10">
                <label class="cursor-pointer label">
                    <span class="label-text dark:text-gray-300">Number on Whatsapp?</span>
                    <input type="checkbox" checked class="toggle toggle-primary" wire:model="teacher.phone.on_whatsapp">
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Degree</span>
                </label>
                <select
                    class="select select-ghost select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.degree">
                    <option disabled selected>Choose Degree</option>
                    <option></option>
                    <option>Below A2</option>
                    <option>A2</option>
                    <option>A1</option>
                    <option>A0</option>
                    <option>Master's Degree</option>
                    <option>PhD</option>
                    <option>Professor</option>
                </select>
            </div>
            <x-daisy.input label="Qualification" wire:model="teacher.qualification" />
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Birth Country</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.birth.country">
                    <option disabled="disabled" selected="selected">Choose Birth Country</option>
                    @foreach ($this->countries as $country)
                        <option value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Residence Country</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="teacher.residential.country">
                    <option disabled="disabled" selected="selected">Choose Residence Country</option>
                    @foreach ($this->countries as $country)
                        <option value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="firstStepSubmit" wire:loading.class="loading disabled">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    <div class="{{ $currentStep != 2 ? 'hidden' : '' }}">
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
            <div class="btn-group">
                <button class="btn btn-secondary" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-primary" wire:click="secondStepSubmit" wire:loading.class="loading disabled">
                    Next
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
    <div class="{{ $currentStep != 3 ? 'hidden' : '' }}">
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
            <div class="btn-group">
                <button class="btn btn-secondary" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-primary" wire:click="thirdStepSubmit" wire:loading.class="loading disabled">
                    Next
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
    <div class="{{ $currentStep != 4 ? 'hidden' : '' }}">
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
        @for ($i = 0; $i < $this->assignedSubjectsCount; $i++)
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                @if (isset($savedSchoolTeacherData->subjects[$i]))
                    <input label="First Name" placeholder="Jane" type="hidden"
                        wire:model="subjects.{{ $i }}.id" />
                @endif
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">School Class Year</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="subjects.{{ $i }}.year">
                        <option disabled="disabled" selected="selected">Select School Class Year</option>
                        <option value=""></option>
                        @foreach ($this->school_class_years as $classYear)
                            <option value="{{ $classYear['id'] }}">{{ $classYear['name'] }}</option>
                        @endforeach
                    </select>
                </div>
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

        <div class="float-right my-4">
            <div class="btn-group">
                <button class="btn btn-secondary" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-primary" wire:click="fourthStepSubmit" wire:loading.class="loading disabled">
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
</div>
