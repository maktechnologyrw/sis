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
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Update extends Component
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

    public $student;
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
    protected $currentRoute;
    public $parents = [];
    public $parentsCount;

    public $isAlertShown = false;

    public function render()
    {
        return view('livewire.student.update', ['provinces' => Province::all(['provincecode', 'provincename'])]);
    }

    public function mount()
    {
        $this->countries = Country::all();
        $this->user = Auth::user();
        $this->school_class_years = SchoolClassCategoryLevelYear::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->school_class_rooms = SchoolClassRoom::where("school_id", "=", $this->user->schoolUser->school_id)->get();
        $this->currentRoute = Route::current();

        if ($this->currentRoute->hasParameter("id")) {
            $this->savedStudentData = Student::find($this->currentRoute->parameters["id"]);

            $this->student["names"]["first"] = $this->savedStudentData->first_name;
            $this->student["names"]["last"] = $this->savedStudentData->last_name;
            $this->student["sex"] = $this->savedStudentData->sex;
            $this->student["date_of_birth"] = $this->savedStudentData->date_of_birth;

            $this->student["birth"]["country"] = $this->savedStudentData->birth_country_id;
            $this->student["birth"]["province"] = $this->savedStudentData->birth_province;
            $this->setDistricts();
            $this->student["birth"]["district"] = $this->savedStudentData->birth_district;
            $this->setSectors();
            $this->student["birth"]["sector"] = $this->savedStudentData->birth_sector;
            $this->setCells();
            $this->student["birth"]["cell"] = $this->savedStudentData->birth_cell;
            $this->setVillages();
            $this->student["birth"]["village"] = $this->savedStudentData->birth_village;

            $this->student["residential"]["country"] = $this->savedStudentData->residential_country_id;
            $this->student["residential"]["province"] = $this->savedStudentData->residential_province;
            $this->setDistricts("residential");
            $this->student["residential"]["district"] = $this->savedStudentData->residential_district;
            $this->setSectors("residential");
            $this->student["residential"]["sector"] = $this->savedStudentData->residential_sector;
            $this->setCells("residential");
            $this->student["residential"]["cell"] = $this->savedStudentData->residential_cell;
            $this->setVillages("residential");
            $this->student["residential"]["village"] = $this->savedStudentData->residential_village;

            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

            $this->studentRegistration = $this->savedStudentData->registrations()->where("school_id", $this->user->schoolUser->school_id)->where("year_id", $currentAcademicYear[0]->year_id)->first();
            $this->registration["year"] = $this->studentRegistration->class_year_id ?? "";
            $this->registration["date"] = $this->studentRegistration->date ?? "";

            if (isset($this->studentRegistration->enrollment)) {
                $enrollmentData = $this->studentRegistration->enrollment;

                $this->enrollment["room"] = $enrollmentData->room_id;
                $this->enrollment["date"] = $enrollmentData->enrolled_at;
                $this->enrollment["start_date"] = $enrollmentData->start_date;
            }

            $this->parentsCount = count($this->savedStudentData->parents);

            for ($i = 0; $i < $this->parentsCount; $i++) {
                $parent = $this->savedStudentData->parents[$i];

                $this->parents[$i]["id"] = $parent->id;
                $this->parents[$i]["names"]["first"] = $parent->first_name;
                $this->parents[$i]["names"]["last"] = $parent->last_name;
                $this->parents[$i]["sex"] = $parent->sex;
                $this->parents[$i]["email"] = $parent->email;
                $this->parents[$i]["type"] = $parent->type;
                // $this->parents[$i]["phone"]["country"] = $parent->user->phone->country_id;
                /* $this->parents[$i]["phone"]["number"] =
                $this->parents[$i]["phone"]["on_whatsapp"] = */
            }
        }
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
        $this->savedStudentData->first_name = $this->student["names"]["first"];
        $this->savedStudentData->last_name = $this->student["names"]["last"];
        $this->savedStudentData->sex = $this->student["sex"];
        $this->savedStudentData->date_of_birth = $this->student["date_of_birth"];
        $this->savedStudentData->birth_country_id = $this->student["birth"]["country"];
        $this->savedStudentData->residential_country_id = $this->student["residential"]["country"];

        $this->savedStudentData->save();

        $this->isAlertShown = true;
    }

    public function secondStepSubmit()
    {
        $this->savedStudentData->birth_province = $this->student["birth"]["province"];
        $this->savedStudentData->birth_district = $this->student["birth"]["district"];
        $this->savedStudentData->birth_sector = $this->student["birth"]["sector"];
        $this->savedStudentData->birth_cell = $this->student["birth"]["cell"];
        $this->savedStudentData->birth_village = $this->student["birth"]["village"];

        $this->savedStudentData->save();
    }

    public function thirdStepSubmit()
    {
        $this->savedStudentData->residential_province = $this->student["residential"]["province"];
        $this->savedStudentData->residential_district = $this->student["residential"]["district"];
        $this->savedStudentData->residential_sector = $this->student["residential"]["sector"];
        $this->savedStudentData->residential_cell = $this->student["residential"]["cell"];
        $this->savedStudentData->residential_village = $this->student["residential"]["village"];

        $this->savedStudentData->save();
    }

    public function fifthStepSubmit()
    {
        if (isset($this->studentRegistration->id)) {
            $this->studentRegistration->class_year_id = $this->registration["year"];
            $this->studentRegistration->date = $this->registration["date"];

            $this->studentRegistration->save();
        } else {
            $currentAcademicYear = CurrentSchoolAcademicYear::select("year_id")->where("school_id", "=", $this->user->schoolUser->school_id)->get();

            $this->studentRegistration = new StudentRegistration;

            $this->studentRegistration->school_id = $this->user->schoolUser->school_id;
            $this->studentRegistration->year_id = $currentAcademicYear[0]->year_id;
            $this->studentRegistration->student_id = $this->savedStudentData->id;
            $this->studentRegistration->class_year_id = $this->registration["year"];
            $this->studentRegistration->date = $this->registration["date"];
            $this->studentRegistration->comment = " ";

            $this->studentRegistration->save();
        }
    }

    public function sixthStepSubmit()
    {
        if (isset($this->studentRegistration->enrollment->id)) {
            $enrollmentData = $this->studentRegistration->enrollment;

            $enrollmentData->room_id = $this->enrollment["room"];
            $enrollmentData->enrolled_at = $this->enrollment["date"];
            $enrollmentData->start_date = $this->enrollment["start_date"];

            $enrollmentData->save();
        } else {
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
    }

    public function incrementParents()
    {
        $this->parentsCount += 1;
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

        $studentParentData = new StudentParent;

        $studentParentData->student_id = $this->savedStudentData->id;
        $studentParentData->parent_id = $parentData->id;

        $studentParentData->save();
    }

    public function fourthStepSubmit()
    {
        foreach ($this->parents as $parent) {
            if (isset($parent["id"])) {
                $parentData = ParentingPerson::find($parent["id"]);

                $parentData->first_name = $parent["names"]["first"];
                $parentData->last_name = $parent["names"]["last"];
                $parentData->sex = $parent["sex"];
                $parentData->email = $parent["email"];
                $parentData->type = $parent["type"];

                $parentData->save();
            } else {
                $parentData = new ParentingPerson;

                $parentData->first_name = $parent["names"]["first"];
                $parentData->last_name = $parent["names"]["last"];
                $parentData->sex = $parent["sex"];
                $parentData->email = $parent["email"];
                $parentData->type = $parent["type"];

                $parentData->save();

                $phoneData = new Phone;

                $phoneData->country_id = $parent["phone"]["country"];
                $phoneData->number = $parent["phone"]["number"];
                $phoneData->on_whatsapp = $parent["phone"]["on_whatsapp"];

                $phoneData->save();

                $newUser = $this->create([
                    "name" => $parent["names"]["first"] . " " . $parent["names"]["last"],
                    "email" => $parent["email"],
                    "password" => "12345678",
                    "password_confirmation" => "12345678"
                ]);

                $userPhoneData = new UserPhone;

                $userPhoneData->user_id = $newUser->id;
                $userPhoneData->phone_id = $phoneData->id;

                $userPhoneData->save();

                $studentParentData = new StudentParent;

                $studentParentData->student_id = $this->savedStudentData->id;
                $studentParentData->parent_id = $parentData->id;

                $studentParentData->save();
            }
        }
    }

    public function hideAlert() {
        $this->isAlertShown = false;
    }
}
