<?php

namespace App\Http\Livewire\Settings\School;

use App\Models\BreaksAndLunch;
use App\Models\DefaultDailyPeriodDuration;
use App\Models\DefaultSchoolDailyPeriod;
use App\Models\DefaultSchoolDay;
use App\Models\SchoolDayTime;
use DASPRiD\EnumTest\WeekDay;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Html\Elements\Div;
use Spatie\Html\Elements\Label;
use Spatie\Html\Elements\Span;

class Timetable extends Component
{
    public $breakCount;
    public $daysOfTheWeek;
    public $times;
    public $user;
    public $breaks;
    public $defaultPeriodDuration;
    public $periodsCount;
    public $periodHtml;
    public $timeline;
    public $componentArray;
    public $periodDuration;

    public function mount()
    {
        // WeekDay
        $this->breakCount = 1;

        $this->daysOfTheWeek = [
            ["day" => "Monday", "abbreviation" => "MON", "status" => false],
            ["day" => "Tuesday", "abbreviation" => "TUE", "status" => false],
            ["day" => "Wednesday", "abbreviation" => "WED", "status" => false],
            ["day" => "Thursday", "abbreviation" => "THU", "status" => false],
            ["day" => "Friday", "abbreviation" => "FRI", "status" => false],
            ["day" => "Saturday", "abbreviation" => "SUN", "status" => false],
            ["day" => "Sunday", "abbreviation" => "SAT", "status" => false],
        ];

        $this->times = [
            "start" => "",
            "end" => "",
        ];

        $this->user = Auth::user();

        $this->periodsCount = 2;
        $this->componentArray = [];

        $startAndEndTimes = SchoolDayTime::where("school_id", $this->user->schoolUser->school_id)->first();

        if ($startAndEndTimes) {
            $this->times["start"] = $startAndEndTimes->start_time;
            $this->times["end"] = $startAndEndTimes->end_time;
            $this->times["id"] = $startAndEndTimes->id;
        }

        $breaksAndLunches = BreaksAndLunch::where("school_id", $this->user->schoolUser->school_id)->get();

        if ($breaksAndLunches && count($breaksAndLunches) > 0) {
            foreach ($breaksAndLunches as $key => $breakAndLunch) {
                $this->breakCount = $key + 1;

                $this->breaks[$key] = [];

                $this->breaks[$key]["id"] = $breakAndLunch->id;
                $this->breaks[$key]["category"] = $breakAndLunch->category;
                $this->breaks[$key]["times"]["start"] = $breakAndLunch->start_time;
                $this->breaks[$key]["times"]["end"] = $breakAndLunch->end_time;
            }
        }

        $schoolDays = DefaultSchoolDay::where("school_id", $this->user->schoolUser->school_id)->get();

        if (count($schoolDays) > 0) {
            $days = [];
            foreach ($schoolDays as $key => $schoolDay) {
                $days[] = ["day" => $this->daysOfTheWeek[$key]["day"], "abbreviation" => $schoolDay->day_of_the_week, "status" => $schoolDay->status, "id" => $schoolDay->id];
            }
            $this->daysOfTheWeek = $days;
        }

        $this->periodDuration = DefaultDailyPeriodDuration::where("school_id", $this->user->schoolUser->school_id)->first();

        if ($this->periodDuration) {
            $this->defaultPeriodDuration = $this->periodDuration->duration;
        }

        $dailySchoolPeriods = DefaultSchoolDailyPeriod::where("school_id", $this->user->schoolUser->school_id)->get();

        if (count($dailySchoolPeriods) > 0) {
            foreach ($dailySchoolPeriods as $key => $dailySchoolPeriod) {
                if ($dailySchoolPeriod->category == "Period") {
                    $this->componentArray[] = ["type" => "P"];
                } else {
                    $this->componentArray[] = ["type" => "B"];
                }
                $this->timeline[$key] = [
                    "id" => $dailySchoolPeriod->id,
                    "category" => $dailySchoolPeriod->category,
                    "start" => $dailySchoolPeriod->since,
                    "end" => $dailySchoolPeriod->until,
                ];
            }
        }

        // $this->periodHtml = html()->div()->class(["grid", "sm:grid-cols-1", "md:grid-cols-4", "gap-4"]);
        // $this->periodHtml = html()->input
        // $this->periodHtml = html()->select()->class(["select", "select-bordered", "w-full", "dark:text-gray-300", "dark:border-gray-600", "dark:bg-gray-700"])->attribute("wire:model", "breaks.{{ $i }}.category")->options(["", "Period"]);
        // $formControl= html()->div()->class(["form-control", "col-span-2"])->child(html()->label()->class("label")->child(html()->span()->class("label-text", "dark:text-gray-300")->text("Category")));
    }

    public function render()
    {
        return view('livewire.settings.school.timetable');
    }

    public function incrementBreaks()
    {
        $this->breakCount++;
    }

    public function saveStartAndEndTimes()
    {
        if (isset($this->times["id"])) {
            $model = SchoolDayTime::find($this->times["id"]);

            $model->start_time = $this->times["start"];
            $model->end_time = $this->times["end"];

            $model->save();
        } else {
            $model = new SchoolDayTime;

            $model->school_id = $this->user->schoolUser->school_id;
            $model->start_time = $this->times["start"];
            $model->end_time = $this->times["end"];

            $model->save();
        }
    }

    public function saveBreaksAndLunches()
    {
        foreach ($this->breaks as $break) {
            if (isset($break["id"])) {
                $model = BreaksAndLunch::find($break["id"]);

                $model->category = $break["category"];
                $model->start_time = $break["times"]["start"];
                $model->end_time = $break["times"]["end"];

                $model->save();
            } else {
                $model = new BreaksAndLunch;

                $model->school_id = $this->user->schoolUser->school_id;
                $model->category = $break["category"];
                $model->start_time = $break["times"]["start"];
                $model->end_time = $break["times"]["end"];

                $model->save();
            }
        }
    }

    public function saveSchoolDays()
    {
        foreach ($this->daysOfTheWeek as $dayOfTheWeek) {
            if (isset($dayOfTheWeek["id"])) {
                $model = DefaultSchoolDay::find($dayOfTheWeek["id"]);

                $model->day_of_the_week = $dayOfTheWeek["abbreviation"];
                $model->status = $dayOfTheWeek["status"];

                $model->save();
            } else {
                $model = new DefaultSchoolDay;

                $model->school_id = $this->user->schoolUser->school_id;
                $model->day_of_the_week = $dayOfTheWeek["abbreviation"];
                $model->status = $dayOfTheWeek["status"];

                $model->save();
            }
        }
    }

    public function saveDefaultPeriodDuration()
    {
        if ($this->periodDuration) {
            $model = $this->periodDuration;

            $model->duration = $this->defaultPeriodDuration;

            $model->save();
        } else {
            $model = new DefaultDailyPeriodDuration;

            $model->school_id = $this->user->schoolUser->school_id;
            $model->duration = $this->defaultPeriodDuration;
            $model->extension = "Minutes";

            $model->save();
        }
    }

    public function periodComponent($index)
    {
        return html()->div()->class(['grid', 'sm:grid-cols-1', 'md:grid-cols-4', 'gap-4'])->child(
            html()->div()->class(['form-control', 'col-span-2'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('Category'),
                ),
            )->child(
                html()->select()->class(['select', 'select-bordered', 'w-full', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700'])->attribute('wire:model', "timeline.$index.category")->options(['' => '', 'Period' => 'Period']),
            ),
        )->child(
            html()->div()->class(['form-control'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('Start Time'),
                ),
            )->child(
                html()->input('time')->class(['input', 'input-bordered', 'shadow-sm', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700', 'dark:focus:shadow-outline-gray'])->attribute('wire:model', "timeline.$index.start"),
            ),
        )->child(
            html()->div()->class(['form-control'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('End Time'),
                ),
            )->child(
                html()->input('time')->class(['input', 'input-bordered', 'shadow-sm', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700', 'dark:focus:shadow-outline-gray'])->attribute('wire:model', "timeline.$index.end"),
            ),
        );
    }

    public function breakComponent($index)
    {
        return html()->div()->class(['grid', 'sm:grid-cols-1', 'md:grid-cols-4', 'gap-4'])->child(
            html()->div()->class(['form-control', 'col-span-2'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('Category'),
                ),
            )->child(
                html()->select()->class(['select', 'select-bordered', 'w-full', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700'])->attribute('wire:model', "timeline.$index.category")->options(['' => '', 'Break' => 'Break', "Lunch" => "Lunch"]),
            ),
        )->child(
            html()->div()->class(['form-control'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('Start Time'),
                ),
            )->child(
                html()->input('time')->class(['input', 'input-bordered', 'shadow-sm', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700', 'dark:focus:shadow-outline-gray'])->attribute('wire:model', "timeline.$index.start"),
            ),
        )->child(
            html()->div()->class(['form-control'])->child(
                html()->label()->class('label')->child(
                    html()->span()->class(['label-text', 'dark:text-gray-300'])->text('End Time'),
                ),
            )->child(
                html()->input('time')->class(['input', 'input-bordered', 'shadow-sm', 'dark:text-gray-300', 'dark:border-gray-600', 'dark:bg-gray-700', 'dark:focus:shadow-outline-gray'])->attribute('wire:model', "timeline.$index.end"),
            ),
        );
    }

    public function addPeriodComponent()
    {
        // P = Period
        $this->componentArray[] = ["type" => "P"];
    }

    public function addBreakComponent()
    {
        // B = Break
        $this->componentArray[] = ["type" => "B"];
    }

    public function saveTimelineComponents()
    {
        foreach ($this->timeline as $timelineComponent) {
            if (isset($timelineComponent["id"])) {
                $model = DefaultSchoolDailyPeriod::find($timelineComponent["id"]);

                $model->category = $timelineComponent["category"];
                $model->since = $timelineComponent["start"];
                $model->until = $timelineComponent["end"];

                $model->save();
            } else {
                $model = new DefaultSchoolDailyPeriod;

                $model->school_id = $this->user->schoolUser->school_id;
                $model->category = $timelineComponent["category"];
                $model->since = $timelineComponent["start"];
                $model->until = $timelineComponent["end"];

                $model->save();
            }
        }
    }
}
