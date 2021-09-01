<?php

namespace App\Http\Livewire\Wizard;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\AcademicYearCategory;
use App\Models\AcademicYearLevel;
use App\Models\AcademicYearRoom;
use App\Models\AcademicYearTerm;
use App\Models\AcademicYearYear;
use App\Models\Cell;
use App\Models\ClassCategory;
use App\Models\ClassCategoryLevel;
use App\Models\ClassCategoryLevelYear;
use App\Models\ClassLevel;
use App\Models\ClassSubject;
use App\Models\ClassYear;
use App\Models\CurrentSchoolAcademicYear;
use Livewire\Component;
use App\Models\Province;
use App\Models\District;
use App\Models\Markable;
use App\Models\School as ModelsSchool;
use App\Models\SchoolClassCategory;
use App\Models\SchoolClassCategoryLevel;
use App\Models\SchoolClassCategoryLevelYear;
use App\Models\SchoolClassLevel;
use App\Models\SchoolClassRoom;
use App\Models\SchoolClassSubject;
use App\Models\SchoolClassYear;
use App\Models\SchoolMarkable;
use App\Models\SchoolSubject;
use App\Models\SchoolTerm;
use App\Models\SchoolUser;
use App\Models\Sector;
use App\Models\Subject;
use App\Models\Team;
use App\Models\Term;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Registration extends Component
{
    use PasswordValidationRules;

    public $currentStep = 1;

    public $listeners = ["classYearsAdded" => 'setClassYears'];

    // public $provinces = [];
    public $districts = [];
    public $sectors = [];
    public $cells = [];
    public $villages = [];

    public $successMsg = '';

    public $readyToLoadProvinces = false;
    public $readyToLoadClassCategories = false;
    public $readyToLoadClassYears = false;

    public $school = [
        'name' => '',
        'motto' => '',
        'established_at' => '',
        'province' => '',
        'district' => '',
        'sector' => '',
        'cell' => '',
        'village' => '',
    ];

    public $categories = [];
    public $levels = [];
    public $years = [];
    public $rooms = [];
    public $academic = [];
    public $admin = [];

    public $classCategoriesCount = 1;
    public $classLevelsCount = 1;
    public $classYearsCount = 1;
    public $classRoomsCount = 1;

    public $classCategories = [];
    public $classLevels = [];
    public $classYears = [];

    public $schoolData;
    public $classCategoriesData = [];
    public $classCategoryLevelsData = [];
    public $classCategoryLevelYearsData = [];

    public $classCategoryLevels = [];
    public $classCategoryLevelYears = [];
    public $schoolSubjects = [];
    public $schoolClassSubjects = [];

    public function mount()
    {
        $this->classCategories = ClassCategory::all();
        $this->classLevels = ClassLevel::all();
        $this->classYears = ClassYear::all();
        $this->classCategoryLevels = ClassCategoryLevel::all();
        $this->classCategoryLevelYears = ClassCategoryLevelYear::all();
    }

    public function setClassYears()
    {
        $arr = [];
        if (isset($this->schoolData->classCategoryLevels)) {
            for ($i = 0; $i < count($this->schoolData->classCategoryLevels); $i++) {
                for ($u = 0; $u < count($this->schoolData->classCategoryLevels[$i]->classYears); $u++) {
                    $arr[] = $this->schoolData->classCategoryLevels[$i]->classYears[$u];
                }
            }
        }
        $this->classCategoryLevelYearsData = $arr;
        return $arr;
    }

    /**
     * Write code on Method
     */

    public function render()
    {
        return view('livewire.wizard.registration', [
            'provinces' => $this->readyToLoadProvinces ? Province::all(['provincecode', 'provincename']) : [],
            'classCategoryLevelYearsData' => $this->readyToLoadClassYears ? $this->setClassYears() : []
        ]);
    }

    public function loadProvinces()
    {
        $this->readyToLoadProvinces = true;
    }

    public function loadClassCategories()
    {
        $this->readyToLoadClassCategories = true;
    }

    public function loadClassYears()
    {
        $this->readyToLoadClassYears = true;
    }

    public function setDistricts()
    {
        $this->districts = District::where('ProvinceCode', '=', $this->school['province'])->get();
    }

    public function setSectors()
    {
        $this->sectors = Sector::where('DistrictCode', '=', $this->school['district'])->get();
    }

    public function setCells()
    {
        $this->cells = Cell::where('SectorCode', '=', $this->school['sector'])->get();
    }

    public function setVillages()
    {
        $this->villages = Village::where('CellCode', '=', $this->school['cell'])->get();
    }

    /* public function setSchoolClassCategories() {
        // $this->classCategoriesData = SchoolClassCategory::where
        $this->classCategoriesData = $this->schoolData->classCategories ?? [];
    } */

    public function incrementCategories()
    {
        $this->classCategoriesCount += 1;
    }

    public function incrementLevels()
    {
        $this->classLevelsCount += 1;
    }

    public function incrementClassYears()
    {
        $this->classYearsCount += 1;
    }

    public function incrementClassRooms()
    {
        $this->classRoomsCount += 1;
    }

    /**
     * Write code on Method
     */
    public function firstStepSubmit()
    {
        $validatedData = $this->validate([
            'school.name' => 'required',
            'school.motto' => 'required',
            'school.established_at' => 'required',
        ]);

        $this->currentStep = 2;
    }

    /**
     * Write code on Method
     */
    public function secondStepSubmit()
    {
        $validatedData = $this->validate([
            'school.province' => 'required',
            'school.district' => 'required',
            'school.sector' => 'required',
            'school.cell' => 'required',
            'school.village' => 'required',
        ]);

        $this->currentStep = 3;

        $this->schoolData = new ModelsSchool;

        $this->schoolData->name = $this->school["name"];
        $this->schoolData->motto = $this->school["motto"];
        $this->schoolData->established_at = $this->school["established_at"];
        $this->schoolData->province = $this->school["province"];
        $this->schoolData->district = $this->school["district"];
        $this->schoolData->sector = $this->school["sector"];
        $this->schoolData->cell = $this->school["cell"];
        $this->schoolData->village = $this->school["village"];

        $this->schoolData->save();

        $subjects = Subject::all();

        for ($i = 0; $i < count($subjects); $i++) {
            $subject = $subjects[$i];

            $schoolSubject = new SchoolSubject;

            $schoolSubject->school_id = $this->schoolData->id;
            $schoolSubject->parent_id = $subject->id;
            $schoolSubject->name = $subject->name;
            $schoolSubject->abbreviation = $subject->abbreviation;

            $schoolSubject->save();

            $this->schoolSubjects[] = $schoolSubject;
        }

        $globalMarkables = Markable::all();

        for ($i=0; $i < count($globalMarkables); $i++) {
            $globalMarkable = $globalMarkables[$i];

            $schoolMarkable = new SchoolMarkable;

            $schoolMarkable->school_id = $this->schoolData->id;
            $schoolMarkable->parent_id = $globalMarkable->id;
            $schoolMarkable->name = $globalMarkable->name;
            $schoolMarkable->is_report_candidate = $globalMarkable->is_report_candidate;

            $schoolMarkable->save();
        }

        $globalTerms = Term::all();

        for ($i=0; $i < count($globalTerms); $i++) {
            $globalTerm = $globalTerms[$i];

            $schoolTerm = new SchoolTerm;

            $schoolTerm->school_id = $this->schoolData->id;
            $schoolTerm->parent_id = $globalTerm->id;
            $schoolTerm->number = $globalTerm->number;
            $schoolTerm->since = $globalTerm->since;
            $schoolTerm->until = $globalTerm->until;

            $schoolTerm->save();
        }
    }

    public function thirdStepSubmit()
    {
        $this->currentStep = 4;
        for ($i = 0; $i < count($this->categories); $i++) {
            $categoryId = $this->categories[$i];
            $schoolId = $this->schoolData->id;

            $classCategory = new SchoolClassCategory;

            $classCategory->school_id = $schoolId;
            $this->classCategories = ClassCategory::all();
            foreach ($this->classCategories as $category) {
                if ($category->id == $categoryId) {
                    $classCategory->name = $category->name;
                    $classCategory->abbreviation = $category->abbreviation;
                    $classCategory->enabled = $category->enabled;
                    $classCategory->parent_id = $category->id;
                }
            }

            $classCategory->save();
            // $this->classCategoriesData[] = $classCategory;
        }
        $this->classCategoriesData = SchoolClassCategory::where("school_id", "=", $this->schoolData->id)->get();
        /* for ($i=0; $i < count($this->classCategoriesData); $i++) {
            $classCategory = $this->classCategoriesData[$i];
            $originalClassCategory = ClassCategory::where("name", "=", $classCategory["name"])->get();
            $classCategory->original_category_id = $originalClassCategory[0]->id;
            $this->classCategoriesData[$i] = $classCategory;
        } */
        /* $validatedData = $this->validate([
            'school.cate' => 'required',
            'school.district' => 'required',
            'school.sector' => 'required',
            'school.cell' => 'required',
            'school.village' => 'required',
        ]);
 */
    }

    public function fourthStepSubmit()
    {

        for ($i = 0; $i < count($this->rooms); $i++) {
            $room = $this->rooms[$i];

            // Retrieve request props
            $roomCategoryId = $room["category"];
            $globalCategoryLevelId = $room["level"];
            $globalCategoryLevelYearId = $room["year"];
            $roomIdentifier = $room["room"];

            // Retrieve global models
            $globalClassCategoryLevel = ClassCategoryLevel::find($globalCategoryLevelId);
            $globalClassLevel = ClassLevel::find($globalClassCategoryLevel->class_level_id);
            // $this->successMsg = $globalClassLevel;

            $globalClassCategoryLevelYear = ClassCategoryLevelYear::find($globalCategoryLevelYearId);
            // $this->successMsg[] = $globalClassCategoryLevelYear;
            $globalClassYear = ClassYear::find($globalClassCategoryLevelYear->year_id);
            // $this->successMsg = $globalClassYear;

            // Copy Used Level To School

            $schoolClassLevel = SchoolClassLevel::firstOrNew(["school_id" => $this->schoolData->id, "parent_id" => $globalClassLevel->id]);

            $schoolClassLevel->name = $globalClassLevel->name;
            $schoolClassLevel->abbreviation = $globalClassLevel->abbreviation;

            $schoolClassLevel->save();

            $schoolClassCategoryLevel = SchoolClassCategoryLevel::firstOrNew(["school_id" => $this->schoolData->id, "parent_id" => $globalClassCategoryLevel->id]);

            $schoolClassCategoryLevel->class_category_id = $roomCategoryId;
            $schoolClassCategoryLevel->class_level_id = $schoolClassLevel->id;
            $schoolClassCategoryLevel->name = $globalClassCategoryLevel->name;

            $schoolClassCategoryLevel->save();

            // Copy Used Year To School
            $schoolClassYear = SchoolClassYear::firstOrNew(["school_id" => $this->schoolData->id, "parent_id" => $globalClassYear->id]);

            $schoolClassYear->name = $globalClassYear->name;
            $schoolClassYear->display_name = $globalClassYear->display_name;

            $schoolClassYear->save();

            $schoolClassCategoryLevelYear = SchoolClassCategoryLevelYear::firstOrNew(["school_id" => $this->schoolData->id, "parent_id" => $globalClassCategoryLevelYear->id, "level_id" => $schoolClassCategoryLevel->id, "year_id" => $schoolClassYear->id]);

            $schoolClassCategoryLevelYear->name = $globalClassCategoryLevelYear->name;

            $schoolClassCategoryLevelYear->save();


            $classSubjects = ClassSubject::where("class_id", "=", $globalClassCategoryLevelYear->id)->get();

            for ($i = 0; $i < count($classSubjects); $i++) {
                $subject = $classSubjects[$i];
                $schoolSubject = SchoolSubject::where("school_id", "=", $this->schoolData->id)->where("parent_id", "=", $subject->id)->get();

                $schoolClassSubject = new SchoolClassSubject;

                $schoolClassSubject->school_id = $this->schoolData->id;
                $schoolClassSubject->class_id = $schoolClassCategoryLevelYear->id;
                $schoolClassSubject->subject_id = $schoolSubject[0]->id;
                $schoolClassSubject->parent_id = $subject->id;
                $schoolClassSubject->name = $subject->name;
                $schoolClassSubject->minutes_per_week = $subject->minutes_per_week;

                $schoolClassSubject->save();

                $this->schoolClassSubjects[] = $schoolClassSubject;
            }

            $classRoom = new SchoolClassRoom;

            $classRoom->school_id = $this->schoolData->id;
            $classRoom->year_id = $schoolClassCategoryLevelYear->id;
            $classRoom->room = $roomIdentifier;
            $classRoom->name = $schoolClassCategoryLevelYear->name . " " . $roomIdentifier;

            $classRoom->save();
        }


        $this->currentStep = 5;
    }

    public function fifthStepSubmit()
    {
        $academicYear = new AcademicYear;

        $academicYear->school_id = $this->schoolData->id;
        $academicYear->name = $this->academic["year"]["name"];
        $academicYear->since = $this->academic["year"]["start"];
        $academicYear->until = $this->academic["year"]["end"];

        $academicYear->save();

        for ($i = 0; $i < count($this->classCategoriesData); $i++) {
            $classCategory = $this->classCategoriesData[$i];

            $schoolClassCategory = new AcademicYearCategory;

            $schoolClassCategory->school_id = $this->schoolData->id;
            $schoolClassCategory->year_id = $academicYear->id;
            $schoolClassCategory->category_id = $classCategory->id;

            $schoolClassCategory->save();
        }

        $schoolClassLevels = SchoolClassLevel::where("school_id", "=", $this->schoolData->id)->get();

        for ($i = 0; $i < count($schoolClassLevels); $i++) {
            $classLevel = $schoolClassLevels[$i];

            $schoolClassLevel = new AcademicYearLevel;

            $schoolClassLevel->school_id = $this->schoolData->id;
            $schoolClassLevel->year_id = $academicYear->id;
            $schoolClassLevel->level_id = $classLevel->id;

            $schoolClassLevel->save();
        }

        $schoolClassYears = SchoolClassYear::where("school_id", "=", $this->schoolData->id)->get();

        for ($i = 0; $i < count($schoolClassYears); $i++) {
            $classYear = $schoolClassYears[$i];

            $schoolClassYear = new AcademicYearYear;

            $schoolClassYear->school_id = $this->schoolData->id;
            $schoolClassYear->year_id = $academicYear->id;
            $schoolClassYear->class_year_id = $classYear->id;

            $schoolClassYear->save();
        }

        $schoolClassSubjects = SchoolClassSubject::where("school_id", "=", $this->schoolData->id)->get();

        for ($i = 0; $i < count($schoolClassSubjects); $i++) {
            $classSubject = $schoolClassSubjects[$i];

            $schoolClassSubject = new AcademicSubject;

            $schoolClassSubject->school_id = $this->schoolData->id;
            $schoolClassSubject->year_id = $academicYear->id;
            $schoolClassSubject->class_id = $classSubject->schoolClassCategoryLevelYear->year_id;
            $schoolClassSubject->subject_id = $classSubject->id;

            $schoolClassSubject->save();
        }

        $schoolClassRooms = SchoolClassRoom::where("school_id", "=", $this->schoolData->id)->get();

        for ($i = 0; $i < count($schoolClassRooms); $i++) {
            $classRoom = $schoolClassRooms[$i];

            $schoolClassRoom = new AcademicYearRoom;

            $schoolClassRoom->school_id = $this->schoolData->id;
            $schoolClassRoom->year_id = $academicYear->id;
            $schoolClassRoom->room_id = $classRoom->id;

            $schoolClassRoom->save();
        }

        $currentAcademicYear = new CurrentSchoolAcademicYear;

        $currentAcademicYear->school_id = $this->schoolData->id;
        $currentAcademicYear->year_id = $academicYear->id;

        $currentAcademicYear->save();

        $schoolTerms = SchoolTerm::where("school_id", "=", $this->schoolData->id)->get();

        for ($i=0; $i < count($schoolTerms); $i++) {
            $schoolTerm = $schoolTerms[$i];

            $academicTerm = new AcademicYearTerm;

            $academicTerm->school_id = $this->schoolData->id;
            $academicTerm->academic_year_id = $academicYear->id;
            $academicTerm->number = $schoolTerm->number;
            $academicTerm->since = $schoolTerm->since;
            $academicTerm->until = $schoolTerm->until;

            $academicTerm->save();
        }

        $this->currentStep = 6;
    }

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }

    public function sixthStepSubmit()
    {
        $newUser = $this->create($this->admin);
        $newUser->assignRole("admin");

        $schoolUser = new SchoolUser;

        $schoolUser->user_id = $newUser->id;
        $schoolUser->school_id = $this->schoolData->id;
        $schoolUser->user_type = "Admin";

        $schoolUser->save();

        Auth::login($newUser);

        redirect("/dashboard");
        // $this->currentStep = 6;
    }

    /**
     * Write code on Method
     */
    /* public function submitForm()
    {
        Team::create([
            'name' => $this->name,
            'price' => $this->price,
            'detail' => $this->detail,
            'status' => $this->status,
        ]);

        $this->successMsg = 'Team successfully created.';

        $this->clearForm();

        $this->currentStep = 1;
    } */

    /**
     * Write code on Method
     */
    public function back($step)
    {
        $this->currentStep = $step;
    }

    /**
     * Write code on Method
     */
    public function clearForm()
    {
        $this->school["name"] = '';
        $this->school["motto"] = '';
        $this->school["established_at"] = '';
        // $this->status = 1;
    }
}
