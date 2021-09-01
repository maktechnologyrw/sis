<div class="grid grid-cols-1">
    <div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
        <div class="alert alert-success {{ $isAlertShown ? '' : 'hidden' }}">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-2 text-success" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <label>Saved successfully!</label>
            </div>
        </div>
        <div>
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                <x-daisy.input label="First Name" placeholder="Jane" wire:model="student.names.first" />
                <x-daisy.input label="Last Name" placeholder="Doe" wire:model="student.names.last" />
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Sex</span>
                    </label>
                    <select
                        class="select select-ghost select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="student.sex">
                        <option disabled="disabled" selected="selected">Choose Sex</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <x-daisy.input label="Date Of Birth" type="date" wire:model="student.date_of_birth" />
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Birth Country</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="student.birth.country">
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
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="student.residential.country">
                        <option disabled="disabled" selected="selected">Choose Residence Country</option>
                        @foreach ($this->countries as $country)
                            <option value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
                        @endforeach
                    </select>
                </div>
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
                    wire:model="student.birth.province" wire:change="setDistricts()">
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
                    wire:model="student.birth.district" wire:change="setSectors()">
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
                    wire:model="student.birth.sector" wire:change="setCells()">
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
                    wire:model="student.birth.cell" wire:change="setVillages()">
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
                    wire:model="student.birth.village">
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
                    wire:model="student.residential.province" wire:init="loadProvinces"
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
                    wire:model="student.residential.district" wire:change="setSectors('residential')">
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
                    wire:model="student.residential.sector" wire:change="setCells('residential')">
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
                    wire:model="student.residential.cell" wire:change="setVillages('residential')">
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
                    wire:model="student.residential.village">
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
            <button type="button" class="btn btn-primary btn-outline" wire:click="incrementParents()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                Add Parent
            </button>
        </div>
        <hr class="mt-4">
        <div>
            @if ($parentsCount > 0)
                @for ($i = 0; $i < $parentsCount; $i++)
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                        @if (isset($savedStudentData->parents[$i]))
                            <input label="First Name" placeholder="Jane" type="hidden"
                                wire:model="parents.{{ $i }}.id" />
                        @endif
                        <x-daisy.input label="First Name" placeholder="Jane"
                            wire:model="parents.{{ $i }}.names.first" />
                        <x-daisy.input label="Last Name" placeholder="Doe"
                            wire:model="parents.{{ $i }}.names.last" />
                    </div>
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                        @if (!isset($savedStudentData->parents[$i]))
                            <div class="grid grid-cols-2 gap-x-4">
                        @endif
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text dark:text-gray-300">Choose Category</span>
                            </label>
                            <select
                                class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                wire:model="parents.{{ $i }}.type">
                                <option disabled="disabled" selected="selected">Choose Category</option>
                                <option>Father</option>
                                <option>Mother</option>
                                <option>Guardian</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text dark:text-gray-300">Choose Sex</span>
                            </label>
                            <select
                                class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                wire:model="parents.{{ $i }}.sex">
                                <option disabled="disabled" selected="selected">Choose Sex</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        @if (!isset($savedStudentData->parents[$i]))
                    </div>
                    <x-daisy.input label="Email" placeholder="example@domain.com"
                        wire:model="parents.{{ $i }}.email" type="email" />
                @endif
        </div>

        @if (!isset($savedStudentData->parents[$i]))
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Phone</span>
                    </label>
                    <div class="relative focus-within:shadow-outline-red">
                        <select wire:model="parents.{{ $i }}.phone.country"
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
                        <input type="text" placeholder="788888888"
                            wire:model="parents.{{ $i }}.phone.number"
                            class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-cool-gray w-5/6 ml-1/6 rounded-l-none border-l-0 input input-bordered">
                    </div>
                </div>
                <div class="form-control md:mt-10">
                    <label class="cursor-pointer label">
                        <span class="label-text dark:text-gray-300">Number on Whatsapp?</span>
                        <input type="checkbox" checked class="toggle toggle-primary"
                            wire:model="parents.{{ $i }}.phone.on_whatsapp">
                    </label>
                </div>
            </div>
        @endif
        <hr class="mt-4" />
        @endfor
    @else
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <x-daisy.input label="First Name" placeholder="Jane" wire:model="parents.0.names.first" />
            <x-daisy.input label="Last Name" placeholder="Doe" wire:model="parents.0.names.last" />
        </div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="grid grid-cols-2 gap-x-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Category</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="parents.0.type">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        <option>Father</option>
                        <option>Mother</option>
                        <option>Guardian</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Sex</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="parents.0.sex">
                        <option disabled="disabled" selected="selected">Choose Sex</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
            <x-daisy.input label="Email" placeholder="example@domain.com" wire:model="parents.0.email" type="email" />
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Phone</span>
                </label>
                <div class="relative focus-within:shadow-outline-red">
                    <select wire:model="parents.0.phone.country"
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
                    <input type="text" placeholder="788888888" wire:model="parents.0.phone.number"
                        class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-cool-gray w-5/6 ml-1/6 rounded-l-none border-l-0 input input-bordered">
                </div>
            </div>
            <div class="form-control md:mt-10">
                <label class="cursor-pointer label">
                    <span class="label-text dark:text-gray-300">Number on Whatsapp?</span>
                    <input type="checkbox" checked class="toggle toggle-primary"
                        wire:model="parents.0.phone.on_whatsapp">
                </label>
            </div>
        </div>
        @endif

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
<div class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800">
    <div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Class</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="registration.year">
                    <option disabled="disabled" selected="selected">Choose Class</option>
                    @foreach ($this->school_class_years as $classYear)
                        <option value="{{ $classYear['id'] }}">{{ $classYear['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <x-daisy.input label="Registration Date" wire:model="registration.date" type="date" />
        </div>

        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="fifthStepSubmit" wire:loading.class="loading disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
</div>
<div
    class="px-6 py-5 mb-8 bg-white md:rounded-lg shadow-md dark:bg-gray-800 {{ $studentRegistration ? '' : 'hidden' }}">
    <div>
        <div class="grid sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Class Room</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="enrollment.room">
                    <option disabled="disabled" selected="selected">Choose Class Room</option>
                    @foreach ($this->school_class_rooms as $classRoom)
                        <option value="{{ $classRoom['id'] }}">{{ $classRoom['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <x-daisy.input label="Admission Date" wire:model="enrollment.date" type="date" />
            <x-daisy.input label="Start Date" wire:model="enrollment.start_date" type="date" />
        </div>

        <div class="float-right my-4">
            <button class="btn btn-primary" wire:click="sixthStepSubmit" wire:loading.class="loading disabled">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
</div>
</div>
