<div class="px-6 py-5 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <ul class="w-full steps dark:text-gray-200" data-theme="cupcake">
        <li {{ $currentStep > 1 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep == 1 ? 'step-neutral' : 'step-success' }}">Student Info</li>
        <li {{ $currentStep > 2 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 2 ? 'step-neutral' : 'step-success' }}">Birth Address</li>
        <li {{ $currentStep > 3 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 3 ? 'step-neutral' : 'step-success' }}">Residential Address</li>
        <li {{ $currentStep > 4 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 4 ? 'step-neutral' : 'step-success' }}">Parents</li>
        <li {{ $currentStep > 5 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 5 ? 'step-neutral' : 'step-success' }}">Registration</li>
        <li {{ $currentStep > 6 ? 'data-content=✓' : '' }}
            class="step {{ $currentStep <= 6 ? 'step-neutral' : 'step-success' }}">Enrollment</li>
    </ul>
    <div>
        {{-- {{ $currentRoute }} --}}
    </div>
    <div class="{{ $currentStep != 1 ? 'hidden' : '' }}">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <x-daisy.input label="First Name" placeholder="Jane" wire:model="student.names.first" />
            <x-daisy.input label="Last Name" placeholder="Doe" wire:model="student.names.last" />
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Sex</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
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
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
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
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="student.residential.country">
                    <option disabled="disabled" selected="selected">Choose Residence Country</option>
                    @foreach ($this->countries as $country)
                        <option value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- <x-button wire:click="firstStepSubmit">Go</x-button>
        <x-daisy.input placeholder="ex: 2021" label="Academic Year" /> --}}
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
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <x-daisy.input label="First Name" placeholder="Jane" wire:model="parent.names.first" />
            <x-daisy.input label="Last Name" placeholder="Doe" wire:model="parent.names.last" />
        </div>
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="grid grid-cols-2 gap-x-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Choose Category</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="parent.type">
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
                        wire:model="parent.sex">
                        <option disabled="disabled" selected="selected">Choose Sex</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
            <x-daisy.input label="Email" placeholder="example@domain.com" wire:model="parent.email" type="email" />
        </div>

        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-y-4 gap-x-6 my-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Phone</span>
                </label>
                <div class="relative focus-within:shadow-outline-red">
                    <select wire:model="parent.phone.country"
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
                    <input type="text" placeholder="788888888" wire:model="parent.phone.number"
                        class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-cool-gray w-5/6 ml-1/6 rounded-l-none border-l-0 input input-bordered">
                </div>
            </div>
            <div class="form-control md:mt-10">
                <label class="cursor-pointer label">
                    <span class="label-text dark:text-gray-400">Number on Whatsapp?</span>
                    <input type="checkbox" checked class="toggle toggle-primary" wire:model="parent.phone.on_whatsapp">
                </label>
            </div>
        </div>

        <div class="float-right my-4">
            <div class="btn-group">
                <button class="btn btn-secondary btn-outline" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-secondary" wire:click="saveAndAddAnotherParent()"
                    wire:loading.class="loading disabled">
                    Save & Add Another Parent
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="btn btn-primary" wire:click="fourthStepSubmit" wire:loading.class="loading disabled">
                    Save & Continue
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
    <div class="{{ $currentStep != 5 ? 'hidden' : '' }}">
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
            <div class="btn-group">
                <button class="btn btn-secondary" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-primary" wire:click="fifthStepSubmit" wire:loading.class="loading disabled">
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
    <div class="{{ $currentStep != 6 ? 'hidden' : '' }}">
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
            <div class="btn-group">
                <button class="btn btn-secondary" wire:click="back({{ $currentStep - 1 }})"
                    wire:loading.class="loading disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button class="btn btn-primary" wire:click="sixthStepSubmit" wire:loading.class="loading disabled">
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
</div>
