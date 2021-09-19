<div class="p-6">
    @if (!empty($successMsg))
        <div class="alert alert-success">
            {{-- {{ json_encode($successMsg) }} --}}
        </div>
    @endif
    <div class="row setup-content" id="step-1">
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
    <div class="row setup-content" id="step-2">
        <div class="col-md-12">
            <h3> School Location</h3>
            <div class="form-control">
                <label class="label">
                    <span class="label-text dark:text-gray-300">Choose Province</span>
                </label>
                <select class="select select-bordered w-full dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    wire:model="school.province" wire:change="setDistricts()">
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

    <div class="row setup-content" id="step-3">
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

    <div class="row setup-content" id="step-6">
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
            <button class="btn btn-primary" wire:click="fourthStepSubmit" wire:loading.class="loading disabled">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>
