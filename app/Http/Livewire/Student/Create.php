<?php

namespace App\Http\Livewire\Student;

use App\Models\Cell;
use App\Models\Country;
use App\Models\CurrentSchoolAcademicYear;
use App\Models\District;
use App\Models\Enrollment;
use App\Models\ParentingPerson;
use App\Models\Phone;
use App\Models\Province;
use App\Models\SchoolClassCategoryLevelYear;
use App\Models\SchoolClassRoom;
use App\Models\SchoolClassYear;
use App\Models\SchoolUser;
use App\Models\Sector;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentRegistration;
use App\Models\Team;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $currentStep = 1;

    public $countries;

    public $birthDistricts = [];
    public $residentialDistricts = [];
    public $birthSectors = [];
    public $residentialSectors = [];
    public $birthCells = [];
    public $residentialCells = [];
    public $birthVillages = [];
    public $residentialVillages = [];

    public $student = [
        "birth" => ["country" => 178],
        "residential" => ["country" => 178]
    ];
    public $parent = ["phone" => ["on_whatsapp" => false]];

    public $readyToLoadProvinces = false;

    public $savedStudentData;

    public $school_class_years;
    public $school_class_rooms;

    public $successMsg;
    public $user;
    public $registration;
    public $currentAcademicYear;
    public $enrollment;
    public $studentRegistration;

    public function mount()
    {
        $this->countries = Country::all();
        $this->user = Auth::user();
        $this->school_class_years = SchoolClassCategoryLevelYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->school_class_rooms = SchoolClassRoom::where("school_id", "=", $this->user->schoolUser->school_id)->get();
    }

    public function render()
    {
        return view('livewire.student.create', ['provinces' => $this->readyToLoadProvinces ? Province::all(['provincecode', 'provincename']) : [],]);
    }

    public function loadProvinces()
    {
        $this->readyToLoadProvinces = true;
    }

    public function setPhoneOnWhatsapp()
    {
        $this->parent["phone"]["on_whatsapp"] = !$this->parent["phone"]["on_whatsapp"];
    }

    public function setDistricts($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialDistricts = District::where('ProvinceCode', '=', $this->student[$prefix]['province'])->get();
                break;
            default:
                $this->birthDistricts = District::where('ProvinceCode', '=', $this->student[$prefix]['province'])->get();
                break;
        }
    }

    public function setSectors($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialSectors = Sector::where('DistrictCode', '=', $this->student[$prefix]['district'])->get();
                break;
            default:
                $this->birthSectors = Sector::where('DistrictCode', '=', $this->student[$prefix]['district'])->get();
                break;
        }
    }

    public function setCells($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialCells = Cell::where('SectorCode', '=', $this->student[$prefix]['sector'])->get();
                break;
            default:
                $this->birthCells = Cell::where('SectorCode', '=', $this->student[$prefix]['sector'])->get();
                break;
        }
    }

    public function setVillages($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialVillages = Village::where('CellCode', '=', $this->student[$prefix]['cell'])->get();
                break;
            default:
                $this->birthVillages = Village::where('CellCode', '=', $this->student[$prefix]['cell'])->get();
                break;
        }
    }

    public function firstStepSubmit()
    {
        /* $validatedData = $this->validate([
            'student.name' => 'required',
            'student.motto' => 'required',
            'student.established_at' => 'required',
        ]); */

        if ($this->student["birth"]["country"] == 178) {
            $this->currentStep = 2;
        } else if ($this->student["residential"]["country"] == 178) {
            $this->currentStep = 3;
        } else {
            $this->currentStep = 4;
        }
    }

    public function secondStepSubmit()
    {
        if ($this->student["residential"]["country"] == 178) {
            $this->currentStep = 3;
        } else {
            $this->currentStep = 4;
        }
    }

    public function thirdStepSubmit()
    {
        $studentData = new Student;

        $studentData->first_name = $this->student["names"]["first"];
        $studentData->last_name = $this->student["names"]["last"];
        $studentData->sex = $this->student["sex"];
        $studentData->date_of_birth = $this->student["date_of_birth"];

        $studentData->birth_country_id = $this->student["birth"]["country"];
        $studentData->birth_province = $this->student["birth"]["province"];
        $studentData->birth_district = $this->student["birth"]["district"];
        $studentData->birth_sector = $this->student["birth"]["sector"];
        $studentData->birth_cell = $this->student["birth"]["cell"];
        $studentData->birth_village = $this->student["birth"]["village"];

        $studentData->residential_country_id = $this->student["residential"]["country"];
        $studentData->residential_province = $this->student["residential"]["province"];
        $studentData->residential_district = $this->student["residential"]["district"];
        $studentData->residential_sector = $this->student["residential"]["sector"];
        $studentData->residential_cell = $this->student["residential"]["cell"];
        $studentData->residential_village = $this->student["residential"]["village"];

        $studentData->save();

        $this->savedStudentData = $studentData;

        $this->currentStep = 4;
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

    public function saveParent()
    {
        $parentData = new ParentingPerson;

        $parentData->first_name = $this->parent["names"]["first"];
        $parentData->last_name = $this->parent["names"]["last"];
        $parentData->sex = $this->parent["sex"];
        $parentData->email = $this->parent["email"];
        $parentData->type = $this->parent["type"];

        $parentData->save();

        $phoneData = new Phone;

        $phoneData->country_id = $this->parent["phone"]["country"];
        $phoneData->number = $this->parent["phone"]["number"];
        $phoneData->on_whatsapp = $this->parent["phone"]["on_whatsapp"];

        $phoneData->save();

        $newUser = $this->create([
            "name" => $this->parent["names"]["first"] . " " . $this->parent["names"]["last"],
            "email" => $this->parent["email"],
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);

        $userPhoneData = new UserPhone;

        $userPhoneData->user_id = $newUser->id;
        $userPhoneData->phone_id = $phoneData->id;

        $userPhoneData->save();

        $newUser->assignRole("parent");

        $schoolUser = new SchoolUser;

        $schoolUser->user_id = $newUser->id;
        $schoolUser->school_id = $this->user->schoolUser->school_id;
        $schoolUser->user_type = "Parent";

        $schoolUser->save();

        $studentParentData = new StudentParent;

        $studentParentData->student_id = $this->savedStudentData->id;
        $studentParentData->parent_id = $parentData->id;

        $studentParentData->save();
    }

    public function saveAndAddAnotherParent()
    {
        $this->saveParent();
        $this->parent = ["phone" => ["on_whatsapp" => false]];
    }

    public function fourthStepSubmit()
    {
        $this->saveParent();
        $this->currentStep = 5;
    }

    public function fifthStepSubmit()
    {
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

        $this->studentRegistration = new StudentRegistration;

        $this->studentRegistration->school_id = $this->user->schoolUser->school_id;
        $this->studentRegistration->year_id = $currentAcademicYear[0]->year_id;
        $this->studentRegistration->student_id = $this->savedStudentData->id;
        $this->studentRegistration->class_year_id = $this->registration["year"];
        $this->studentRegistration->date = $this->registration["date"];
        $this->studentRegistration->comment = " ";

        $this->studentRegistration->save();
        $this->currentStep = 6;
    }

    public function sixthStepSubmit()
    {
        $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

        $enrollmentData = new Enrollment;

        $enrollmentData->school_id = $this->user->schoolUser->school_id;
        $enrollmentData->year_id = $currentAcademicYear[0]->year_id;
        $enrollmentData->registration_id = $this->studentRegistration->id;
        $enrollmentData->room_id = $this->enrollment["room"];
        $enrollmentData->enrolled_at = $this->enrollment["date"];
        $enrollmentData->start_date = $this->enrollment["start_date"];

        $enrollmentData->save();
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }
}
