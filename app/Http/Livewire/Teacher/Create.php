<?php

namespace App\Http\Livewire\Teacher;

use App\Models\AcademicSubject;
use App\Models\Cell;
use App\Models\Country;
use App\Models\CurrentSchoolAcademicYear;
use App\Models\District;
use App\Models\Phone;
use App\Models\Province;
use App\Models\SchoolClassCategoryLevelYear;
use App\Models\SchoolClassRoom;
use App\Models\SchoolClassSubject;
use App\Models\SchoolSubject;
use App\Models\SchoolTeacher;
use App\Models\SchoolUser;
use App\Models\Sector;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\Team;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Faker\Factory;

class Create extends Component
{
    public $currentStep = 1;
    public $teacher = [
        "birth" => ["country" => 178],
        "residential" => ["country" => 178],
        "phone" => ["country" => 178]
    ];
    public $countries;
    public $readyToLoadProvinces = false;
    public $birthDistricts = [];
    public $residentialDistricts = [];
    public $birthSectors = [];
    public $residentialSectors = [];
    public $birthCells = [];
    public $residentialCells = [];
    public $birthVillages = [];
    public $residentialVillages = [];
    public $savedTeacherData;
    public $school_class_years;
    public $school_class_rooms;
    public $user;
    public $currentAcademicYear;
    public $schoolClassSubjects;
    public $savedSchoolTeacherData;
    public $assignedSubjectsCount = 1;
    public $successMsg;
    public $subjects = [];
    private $faker;

    public function render()
    {
        return view('livewire.teacher.create', ['provinces' => $this->readyToLoadProvinces ? Province::all(['provincecode', 'provincename']) : [],]);
    }

    public function mount()
    {
        $this->countries = Country::all();
        $this->user = Auth::user();
        $this->school_class_years = SchoolClassCategoryLevelYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->currentAcademicYear = CurrentSchoolAcademicYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        // $this->successMsg = $this->currentAcademicYear;
        $this->school_class_rooms = SchoolClassRoom::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->schoolClassSubjects = AcademicSubject::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->faker = Factory::create();
    }

    public function firstStepSubmit()
    {
        if ($this->teacher["birth"]["country"] == 178) {
            $this->currentStep = 2;
        } else if ($this->teacher["residential"]["country"] == 178) {
            $this->currentStep = 3;
        } else {
            $this->currentStep = 4;
        }
    }

    public function loadProvinces()
    {
        $this->readyToLoadProvinces = true;
    }

    public function setDistricts($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialDistricts = District::where('ProvinceCode', '=', $this->teacher[$prefix]['province'])->get();
                break;
            default:
                $this->birthDistricts = District::where('ProvinceCode', '=', $this->teacher[$prefix]['province'])->get();
                break;
        }
    }

    public function setSectors($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialSectors = Sector::where('DistrictCode', '=', $this->teacher[$prefix]['district'])->get();
                break;
            default:
                $this->birthSectors = Sector::where('DistrictCode', '=', $this->teacher[$prefix]['district'])->get();
                break;
        }
    }

    public function setCells($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialCells = Cell::where('SectorCode', '=', $this->teacher[$prefix]['sector'])->get();
                break;
            default:
                $this->birthCells = Cell::where('SectorCode', '=', $this->teacher[$prefix]['sector'])->get();
                break;
        }
    }

    public function setVillages($prefix = 'birth')
    {
        switch ($prefix) {
            case 'residential':
                $this->residentialVillages = Village::where('CellCode', '=', $this->teacher[$prefix]['cell'])->get();
                break;
            default:
                $this->birthVillages = Village::where('CellCode', '=', $this->teacher[$prefix]['cell'])->get();
                break;
        }
    }

    public function secondStepSubmit()
    {
        if ($this->teacher["residential"]["country"] == 178) {
            $this->currentStep = 3;
        } else {
            $this->currentStep = 4;
        }
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function thirdStepSubmit()
    {
        $teacherData = new Teacher;

        $teacherData->first_name = $this->teacher["names"]["first"];
        $teacherData->last_name = $this->teacher["names"]["last"];
        $teacherData->sex = $this->teacher["sex"];
        $teacherData->date_of_birth = $this->teacher["date_of_birth"];
        $teacherData->email = $this->teacher["email"];
        $teacherData->degree = $this->teacher["degree"];
        $teacherData->qualification = $this->teacher["qualification"];

        $teacherData->birth_country_id = $this->teacher["birth"]["country"];
        $teacherData->birth_province = $this->teacher["birth"]["province"];
        $teacherData->birth_district = $this->teacher["birth"]["district"];
        $teacherData->birth_sector = $this->teacher["birth"]["sector"];
        $teacherData->birth_cell = $this->teacher["birth"]["cell"];
        $teacherData->birth_village = $this->teacher["birth"]["village"];

        $teacherData->residential_country_id = $this->teacher["residential"]["country"];
        $teacherData->residential_province = $this->teacher["residential"]["province"];
        $teacherData->residential_district = $this->teacher["residential"]["district"];
        $teacherData->residential_sector = $this->teacher["residential"]["sector"];
        $teacherData->residential_cell = $this->teacher["residential"]["cell"];
        $teacherData->residential_village = $this->teacher["residential"]["village"];

        $teacherData->save();

        $this->savedTeacherData = $teacherData;

        $schoolTeacher = new SchoolTeacher;

        $schoolTeacher->school_id = $this->user->schoolUser->school_id;
        $schoolTeacher->academic_year_id = $this->currentAcademicYear[0]->year_id;
        $schoolTeacher->teacher_id = $teacherData->id;

        $schoolTeacher->save();

        $this->savedSchoolTeacherData = $schoolTeacher;

        $phoneData = new Phone;

        $phoneData->country_id = $this->teacher["phone"]["country"];
        $phoneData->number = $this->teacher["phone"]["number"];
        $phoneData->on_whatsapp = $this->teacher["phone"]["on_whatsapp"];

        $phoneData->save();

        $newUser = $this->create([
            "name" => $this->teacher["names"]["first"] . " " . $this->teacher["names"]["last"],
            "email" => $this->teacher["email"],
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);

        $this->currentStep = 4;
    }

    public function incrementSubjects()
    {
        $this->assignedSubjectsCount += 1;
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

    public function fourthStepSubmit()
    {
        foreach ($this->subjects as $subject) {
            $teacherSubject = new TeacherSubject;

            $teacherSubject->school_id = $this->user->schoolUser->school_id;
            $teacherSubject->year_id = $this->currentAcademicYear[0]->year_id;
            $teacherSubject->teacher_id = $this->savedSchoolTeacherData->id;
            $teacherSubject->subject_id = $subject["subject"];

            $schoolSubject = SchoolClassSubject::where("id", "=", $subject["subject"])->get();

            $teacherSubject->name = $schoolSubject[0]->schoolClassCategoryLevelYear->name . " - " . $schoolSubject[0]->name;

            $teacherSubject->save();
        }

        $this->currentStep = 5;
    }
}
