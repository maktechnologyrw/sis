<div class="p-6">
    @if (!empty($successMsg))
        <div class="alert alert-success">
            {{ json_encode($successMsg) }}
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
            <label class="block text-sm my-4">
                <span class="text-gray-700 dark:text-gray-400">School Name:</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="ex: G.S Murambi" type="text" wire:model="school.name" required autofocus />
                @error('school.name') <span class="error">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm my-4">
                <span class="text-gray-700 dark:text-gray-400">School Motto:</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="ex: No Pain, No Gain" type="text" wire:model="school.motto" />
                @error('school.motto') <span class="error">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm my-4">
                <span class="text-gray-700 dark:text-gray-400">Establishment Year:</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="ex: 2011" type="text" wire:model="school.established_at" />
                @error('school.established_at') <span class="error">{{ $message }}</span> @enderror
            </label>
            {{-- <p>
                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                    href="{{ route('login') }}">
                    Already have an account? Login
                </a>
            </p> --}}
            <div class="float-right my-4">
                <button
                    class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click="firstStepSubmit" type="button">
                    Next
                </button>
            </div>
        </div>
    </div>
    <div class="row setup-content {{ $currentStep != 2 ? 'hidden' : '' }}" id="step-2">
        <div class="col-md-12">
            <h3> School Location</h3>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Province
                </span>
                <div>
                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="school.province" wire:init="loadProvinces" wire:change="setDistricts()">
                        <option></option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['provincecode'] }}">{{ $province['provincename'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('school.province') <span class="error">{{ $message }}</span> @enderror
                </div>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    District
                </span>
                <div>
                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="school.district" wire:change="setSectors()">
                        <option></option>
                        @foreach ($districts as $district)
                            <option value="{{ $district['DistrictCode'] }}">{{ $district['DistrictName'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('school.district') <span class="error">{{ $message }}</span> @enderror
                </div>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Sector
                </span>
                <div>
                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="school.sector" wire:change="setCells()">
                        <option></option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector['SectorCode'] }}">{{ $sector['SectorName'] }}</option>
                        @endforeach
                    </select>
                    @error('school.sector') <span class="error">{{ $message }}</span> @enderror
                </div>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Cell
                </span>
                <div>
                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="school.cell" wire:change="setVillages()">
                        <option></option>
                        @foreach ($cells as $cell)
                            <option value="{{ $cell['CellCode'] }}">{{ $cell['CellName'] }}</option>
                        @endforeach
                    </select>
                    @error('school.cell') <span class="error">{{ $message }}</span> @enderror
                </div>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Village
                </span>
                <div>
                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="school.village">
                        <option></option>
                        @foreach ($villages as $village)
                            <option value="{{ $village['VillageCode'] }}">{{ $village['VillageName'] }}</option>
                        @endforeach
                    </select>
                    @error('school.village') <span class="error">{{ $message }}</span> @enderror
                </div>
            </label>
            <div class="float-right my-4">
                <button
                    class="px-10 py-4 text-md uppercase font-bold leading-5 text-purple-600 transition-colors duration-150 bg-white border border-purple-600 rounded-lg active:bg-purple-600 active:text-white hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click="back({{ $currentStep - 1 }})" type="button">
                    Back
                </button>
                <button
                    class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click="secondStepSubmit" type="button">
                    Next
                </button>
            </div>
        </div>
    </div>

    <div class="row setup-content {{ $currentStep != 3 ? 'hidden' : '' }}" id="step-3">
        <div class="col-md-12">
            <div class="text-right">
                <button type="button" class="btn btn-primary" wire:click="incrementCategories()">Add Category</button>
            </div>
        </div>
        <div class="col-md-12">
            @for ($i = 0; $i < $this->classCategoriesCount; $i++)
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Category {{ $i + 1 }}:
                    </span>
                    <div>
                        <select
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            wire:model="categories.{{ $i }}">
                            <option></option>
                            @foreach ($this->classCategories as $classCategory)
                                <option value="{{ $classCategory['id'] }}">{{ $classCategory['name'] }}</option>
                            @endforeach
                        </select>
                        @error('categories.{{ $i }}') <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
            @endfor
            <div class="float-right my-4">
                <button
                    class="px-10 py-4 text-md uppercase font-bold leading-5 text-purple-600 transition-colors duration-150 bg-white border border-purple-600 rounded-lg active:bg-purple-600 active:text-white hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click="back({{ $currentStep - 1 }})" type="button">
                    Back
                </button>
                <button
                    class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click="thirdStepSubmit" type="button">
                    Next
                </button>
            </div>
        </div>
    </div>

    <div class="row setup-content {{ $currentStep != 4 ? 'hidden' : '' }}" id="step-6">
        <div class="col-md-12">
            <div class="text-right">
                <button type="button" class="btn btn-primary" wire:click="incrementClassRooms()">Add Class
                    Year</button>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
            @for ($i = 0; $i < $this->classRoomsCount; $i++)
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Category {{ $i + 1 }}:
                    </span>
                    <div>
                        <select
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            wire:model="rooms.{{ $i }}.category">
                            <option></option>
                            @foreach ($this->classCategoriesData as $classCategoryData)
                                <option value="{{ $classCategoryData->id }}">
                                    {{ $classCategoryData->name }}</option>
                            @endforeach
                        </select>
                        @error('rooms.{{ $i }}.category') <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Level {{ $i + 1 }}:
                        {{-- {{ json_encode($this->classCategoryLevels) }} --}}
                        {{-- {{ json_encode($this->classCategoryLevelYears) }} --}}
                        {{-- {{ json_encode($this->classCategoriesData) }} --}}
                        {{-- {{ json_encode($this->rooms) }} --}}
                    </span>
                    <div>
                        <select
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            wire:model="rooms.{{ $i }}.level">
                            <option></option>
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
                        @error('rooms.{{ $i }}.level') <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Class Year {{ $i + 1 }}:
                    </span>
                    <div>
                        <select
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            wire:model="rooms.{{ $i }}.year">
                            <option></option>
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
                        @error('rooms.{{ $i }}.year') <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
                <label class="block text-sm my-4">
                    <span class="text-gray-700 dark:text-gray-400">Room Identifier:</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="ex: 2011" type="text" wire:model="rooms.{{ $i }}.room" />
                    @error('rooms.{{ $i }}.room') <span class="error">{{ $message }}</span> @enderror
                </label>
            @endfor
        </div>
        <div class="float-right my-4">
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-purple-600 transition-colors duration-150 bg-white border border-purple-600 rounded-lg active:bg-purple-600 active:text-white hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="back({{ $currentStep - 1 }})" type="button">
                Back
            </button>
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="fourthStepSubmit" type="button">
                Next
            </button>
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
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-purple-600 transition-colors duration-150 bg-white border border-purple-600 rounded-lg active:bg-purple-600 active:text-white hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="back({{ $currentStep - 1 }})" type="button">
                Back
            </button>
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="fifthStepSubmit" type="button">
                Next
            </button>
        </div>
    </div>

    <div class="row setup-content {{ $currentStep != 6 ? 'hidden' : '' }}" id="step-7">
        <div class="col-md-12">
            <h3> Step 3</h3>
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Jane Doe" type="text" wire:model="admin.name" required autocomplete="name" />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Jane Doe" type="email" wire:model="admin.email" required />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="***************" type="password" wire:model="admin.password" required
                    autocomplete="new-password" />
            </label>
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
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-purple-600 transition-colors duration-150 bg-white border border-purple-600 rounded-lg active:bg-purple-600 active:text-white hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="back({{ $currentStep - 1 }})" type="button">
                Back
            </button>
            <button
                class="px-10 py-4 text-md uppercase font-bold leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                wire:click="sixthStepSubmit" type="button">
                Finish
            </button>
        </div>
    </div>
</div>
