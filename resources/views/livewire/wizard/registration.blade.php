<div class="p-6">
    @if (!empty($successMsg))
        <div class="alert alert-success">
            {{-- {{ json_encode($successMsg) }} --}}
        </div>
    @endif
    <ul class="w-full steps dark:text-gray-200" data-theme="cupcake">
        <li class="step {{ $currentStep != 1 ? 'step-neutral' : 'step-primary' }}">Basic Info</li>
        <li class="step {{ $currentStep != 2 ? 'step-neutral' : 'step-primary' }}">School Location</li>
        <li class="step {{ $currentStep != 3 ? 'step-neutral' : 'step-primary' }}">Categories</li>
        <li class="step {{ $currentStep != 4 ? 'step-neutral' : 'step-primary' }}">Grab the moon</li>
        <li class="step {{ $currentStep != 5 ? 'step-neutral' : 'step-primary' }}">Grab the moon</li>
        <li class="step {{ $currentStep != 6 ? 'step-neutral' : 'step-primary' }}">Sit on toilet</li>
    </ul>
    <div class="row setup-content {{ $currentStep != 1 ? 'hidden' : '' }}" id="step-1">
        <div class="col-md-12">
            <h3> Step 1</h3>
            <x-daisy.input label="School Name" placeholder="ex: G.S Murambi" wire:model="school.name" />
            <x-daisy.input label="School Motto" placeholder="ex: No Pain, No Gain" wire:model="school.motto" />
            <x-daisy.input label="Establishment Year" placeholder="ex: 2011" wire:model="school.established_at" />
            <div class="float-right my-4">
                <button class="btn btn-primary" wire:click="firstStepSubmit" wire:loading.class="loading disabled">
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
    <div class="row setup-content {{ $currentStep != 2 ? 'hidden' : '' }}" id="step-2">
        <div class="col-md-12">
            <h3> School Location</h3>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Province</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="school.province" wire:change="setDistricts()" wire:init="loadProvinces">
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
                    wire:model="school.district" wire:change="setSectors()">
                    <option disabled="disabled" selected="selected">Choose District</option>
                    @foreach ($districts as $district)
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
                    wire:model="school.sector" wire:change="setCells()">
                    <option disabled="disabled" selected="selected">Choose Sector</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector['SectorCode'] }}">{{ $sector['SectorName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Cell</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="school.cell" wire:change="setVillages()">
                    <option disabled="disabled" selected="selected">Choose Cell</option>
                    @foreach ($cells as $cell)
                        <option value="{{ $cell['CellCode'] }}">{{ $cell['CellName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Village</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="school.village">
                    <option disabled="disabled" selected="selected">Choose Village</option>
                    @foreach ($villages as $village)
                        <option value="{{ $village['VillageCode'] }}">{{ $village['VillageName'] }}</option>
                    @endforeach
                </select>
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
    </div>

    <div class="row setup-content {{ $currentStep != 3 ? 'hidden' : '' }}" id="step-3">
        <div class="col-md-12">
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-outline" wire:click="incrementCategories()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Add Category
                </button>
            </div>
        </div>
        <div class="col-md-12">
            @for ($i = 0; $i < $this->classCategoriesCount; $i++)
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Category {{ $i + 1 }}</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="categories.{{ $i }}">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        @foreach ($this->classCategories as $classCategory)
                            <option value="{{ $classCategory['id'] }}">{{ $classCategory['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endfor
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
    </div>

    <div class="row setup-content {{ $currentStep != 4 ? 'hidden' : '' }}" id="step-6">
        <div class="col-md-12">
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-outline" wire:click="incrementClassRooms()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd" />
                    </svg>
                    Add Class Year
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
            @for ($i = 0; $i < $this->classRoomsCount; $i++)
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Category {{ $i + 1 }}</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="rooms.{{ $i }}.category">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        @foreach ($this->classCategoriesData as $classCategoryData)
                            <option value="{{ $classCategoryData->id }}">
                                {{ $classCategoryData->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Level {{ $i + 1 }}</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="rooms.{{ $i }}.level">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        @foreach ($this->classCategoryLevels as $classLevel)
                            @for ($u = 0; $u < count($this->rooms); $u++)
                                @if ($i == $u)
                                    @isset($this->rooms[$i]['category'])
                                        @foreach ($this->classCategoriesData as $classCategoryData)
                                            {{ json_encode($classCategoryData) }}
                                            @if ($classCategoryData->id == $this->rooms[$i]['category'])
                                                @if ($classLevel->class_category_id == $classCategoryData->parent_id)
                                                    <option value="{{ $classLevel->id }}">{{ $classLevel->name }}
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endisset
                                @endif
                            @endfor
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text dark:text-gray-300">Class Year {{ $i + 1 }}</span>
                    </label>
                    <select
                        class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                        wire:model="rooms.{{ $i }}.year">
                        <option disabled="disabled" selected="selected">Choose Category</option>
                        @foreach ($this->classCategoryLevelYears as $classYear)
                            @for ($u = 0; $u < count($this->rooms); $u++)
                                @if ($i == $u)
                                    @isset($this->rooms[$i]['level'])
                                        @if ($classYear->level_id == $this->rooms[$i]['level'])
                                            <option value="{{ $classYear['id'] }}">
                                                {{ $classYear['name'] }}</option>
                                        @endif
                                    @endisset
                                @endif
                            @endfor
                        @endforeach
                    </select>
                </div>
                <x-daisy.input label="Room Identifier" placeholder="ex: A"
                    wire:model="rooms.{{ $i }}.room" />
            @endfor
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
                <button class="btn btn-primary" wire:click="fourthStepSubmit" wire:loading.class="loading disabled">
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

    <div class="row setup-content {{ $currentStep != 5 ? 'hidden' : '' }}" id="step-7">
        <div class="col-md-12">
            <h3> Step 3</h3>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Academic Year</span>
                </label>
                <input placeholder="ex: 2021" wire:model="academic.year.name" class="input input-bordered" type="text">
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Start Date</span>
                </label>
                <input wire:model="academic.year.start" class="input input-bordered" type="date">
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">End Date</span>
                </label>
                <input wire:model="academic.year.end" class="input input-bordered" type="date">
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

    <div class="row setup-content {{ $currentStep != 6 ? 'hidden' : '' }}" id="step-7">
        <div class="col-md-12">
            <h3> Step 3</h3>
            <x-daisy.input label="Admin Name" placeholder="ex: John Doe" wire:model="admin.name" />
            {{-- <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Jane Doe" type="text" wire:model="admin.name" required autocomplete="name" />
            </label> --}}
            <x-daisy.input label="Admin Email" placeholder="ex: example@gmail.com" type="email"
                wire:model="admin.email" />
            {{-- <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Jane Doe" type="email" wire:model="admin.email" required />
            </label> --}}
            <x-daisy.input label="Admin Password" placeholder="***************" type="password"
                wire:model="admin.password" />
            {{-- <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="***************" type="password" wire:model="admin.password" required
                    autocomplete="new-password" />
            </label> --}}
            {{-- <x-daisy.input label="Confirm password" placeholder="***************" type="password" wire:model="admin.password_confirmation" /> --}}
            {{-- <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Confirm password</span>
                </label>
                <input placeholder="***************" type="password" wire:model="admin.password_confirmation"
                    class="input input-bordered shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-gray">
            </div> --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Confirm password
                </span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="***************" type="password" wire:model="admin.password_confirmation" required
                    autocomplete="new-password" />
            </label>

            <!-- You should use a button here, as the anchor is only used for the example  -->

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
