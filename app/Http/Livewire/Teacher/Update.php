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
use App\Models\UserPhone;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Faker\Factory;
use Illuminate\Support\Facades\Route;

class Update extends Component
{
    public $currentStep = 1;
    public $teacher;
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
    protected $currentRoute;

    public function render()
    {
        return view('livewire.teacher.update', ['provinces' => $this->readyToLoadProvinces ? Province::all(['provincecode', 'provincename']) : [],]);
    }

    public function mount()
    {
        $this->countries = Country::all();
        $this->user = Auth::user();
        $this->school_class_years = SchoolClassCategoryLevelYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->currentAcademicYear = CurrentSchoolAcademicYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->school_class_rooms = SchoolClassRoom::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->schoolClassSubjects = AcademicSubject::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->faker = Factory::create();
        $this->currentRoute = Route::current();

        if ($this->currentRoute->hasParameter("id")) {
            $this->savedTeacherData = Teacher::find($this->currentRoute->parameters["id"]);

            $this->teacher["names"]["first"] = $this->savedTeacherData->first_name;
            $this->teacher["names"]["last"] = $this->savedTeacherData->last_name;
            $this->teacher["sex"] = $this->savedTeacherData->sex;
            $this->teacher["date_of_birth"] = $this->savedTeacherData->date_of_birth;
            $this->teacher["email"] = $this->savedTeacherData->email;
            $this->teacher["degree"] = $this->savedTeacherData->degree;
            $this->teacher["qualification"] = $this->savedTeacherData->qualification;

            $this->teacher["birth"]["country"] = $this->savedTeacherData->birth_country_id;
            $this->teacher["birth"]["province"] = $this->savedTeacherData->birth_province;
            $this->setDistricts();
            $this->teacher["birth"]["district"] = $this->savedTeacherData->birth_district;
            $this->setSectors();
            $this->teacher["birth"]["sector"] = $this->savedTeacherData->birth_sector;
            $this->setCells();
            $this->teacher["birth"]["cell"] = $this->savedTeacherData->birth_cell;
            $this->setVillages();
            $this->teacher["birth"]["village"] = $this->savedTeacherData->birth_village;

            $this->teacher["residential"]["country"] = $this->savedTeacherData->residential_country_id;
            $this->teacher["residential"]["province"] = $this->savedTeacherData->residential_province;
            $this->setDistricts("residential");
            $this->teacher["residential"]["district"] = $this->savedTeacherData->residential_district;
            $this->setSectors("residential");
            $this->teacher["residential"]["sector"] = $this->savedTeacherData->residential_sector;
            $this->setCells("residential");
            $this->teacher["residential"]["cell"] = $this->savedTeacherData->residential_cell;
            $this->setVillages("residential");
            $this->teacher["residential"]["village"] = $this->savedTeacherData->residential_village;

            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

            $this->savedSchoolTeacherData = SchoolTeacher::where("school_id", "=", $this->user->schoolUser->school_id)->where("academic_year_id", "=", $currentAcademicYear[0]->year_id)->where("teacher_id", "=", $this->savedTeacherData->id)->get();

            if (count($this->savedSchoolTeacherData) == 0) {
                $schoolTeacher = new SchoolTeacher;

                $schoolTeacher->school_id = $this->user->schoolUser->school_id;
                $schoolTeacher->academic_year_id = $this->currentAcademicYear[0]->year_id;
                $schoolTeacher->teacher_id = $this->savedTeacherData->id;

                $schoolTeacher->save();

                $this->savedSchoolTeacherData = $schoolTeacher;
            } else {
                $this->savedSchoolTeacherData = $this->savedSchoolTeacherData[0];
            }

            $this->assignedSubjectsCount = count($this->savedSchoolTeacherData->subjects);

            for ($i = 0; $i < $this->assignedSubjectsCount; $i++) {
                $subject = $this->savedSchoolTeacherData->subjects[$i];

                $schoolSubject = SchoolClassSubject::find($subject["subject_id"]);

                $this->subjects[$i]["id"] = $subject->id;
                $this->subjects[$i]["year"] = $schoolSubject->schoolClassCategoryLevelYear->id;
                $this->subjects[$i]["subject"] = $schoolSubject->id;
            }
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

    public function firstStepSubmit()
    {
        $this->savedTeacherData->first_name = $this->teacher["names"]["first"];
        $this->savedTeacherData->last_name = $this->teacher["names"]["last"];
        $this->savedTeacherData->sex = $this->teacher["sex"];
        $this->savedTeacherData->date_of_birth = $this->teacher["date_of_birth"];
        $this->savedTeacherData->email = $this->teacher["email"];
        $this->savedTeacherData->degree = $this->teacher["degree"];
        $this->savedTeacherData->qualification = $this->teacher["qualification"];
        $this->savedTeacherData->birth_country_id = $this->teacher["birth"]["country"];
        $this->savedTeacherData->residential_country_id = $this->teacher["residential"]["country"];

        $this->savedTeacherData->save();

        noty('Your message');

        /* $phoneData = new Phone;

        $phoneData->country_id = $this->parent["phone"]["country"];
        $phoneData->number = $this->teacher["phone"]["number"];
        $phoneData->on_whatsapp = $this->teacher["phone"]["on_whatsapp"];

        $phoneData->save();

        $newUser = User::where("email", $this->teacher["email"])->get();

        if (count($newUser) == 0) {
            $newUser = $this->create([
                "name" => $this->teacher["names"]["first"] . " " . $this->teacher["names"]["last"],
                "email" => $this->teacher["email"],
                "password" => "12345678",
                "password_confirmation" => "12345678"
            ]);
        } else {
            $newUser = $newUser[0];
        }

        $userPhoneData = new UserPhone;

        $userPhoneData->user_id = $newUser->id;
        $userPhoneData->phone_id = $phoneData->id;

        $userPhoneData->save(); */
    }

    public function secondStepSubmit()
    {
        $this->savedTeacherData->birth_province = $this->teacher["birth"]["province"];
        $this->savedTeacherData->birth_district = $this->teacher["birth"]["district"];
        $this->savedTeacherData->birth_sector = $this->teacher["birth"]["sector"];
        $this->savedTeacherData->birth_cell = $this->teacher["birth"]["cell"];
        $this->savedTeacherData->birth_village = $this->teacher["birth"]["village"];

        $this->savedTeacherData->save();
    }

    public function thirdStepSubmit()
    {
        $this->savedTeacherData->residential_province = $this->teacher["residential"]["province"];
        $this->savedTeacherData->residential_district = $this->teacher["residential"]["district"];
        $this->savedTeacherData->residential_sector = $this->teacher["residential"]["sector"];
        $this->savedTeacherData->residential_cell = $this->teacher["residential"]["cell"];
        $this->savedTeacherData->residential_village = $this->teacher["residential"]["village"];

        $this->savedTeacherData->save();
    }

    public function incrementSubjects()
    {
        $this->assignedSubjectsCount += 1;
    }

    public function fourthStepSubmit()
    {
        foreach ($this->subjects as $subject) {
            if (isset($subject["id"])) {
                $teacherSubject = TeacherSubject::find($subject["id"]);

                $teacherSubject->subject_id = $subject["subject"];

                $schoolSubject = SchoolClassSubject::find($subject["subject"]);

                $teacherSubject->name = $schoolSubject->schoolClassCategoryLevelYear->name . " - " . $schoolSubject->name;

                $teacherSubject->save();
            } else {
                $teacherSubject = new TeacherSubject;

                $teacherSubject->school_id = $this->user->schoolUser->school_id;
                $teacherSubject->year_id = $this->currentAcademicYear[0]->year_id;
                $teacherSubject->teacher_id = $this->savedSchoolTeacherData->id;
                $teacherSubject->subject_id = $subject["subject"];

                $schoolSubject = SchoolClassSubject::find($subject["subject"]);

                $teacherSubject->name = $schoolSubject->schoolClassCategoryLevelYear->name . " - " . $schoolSubject->name;

                $teacherSubject->save();
            }
        }
    }
}
