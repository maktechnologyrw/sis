<?php

namespace App\Http\Livewire\Settings\School;

use App\Models\Province;
use Livewire\Component;

class Info extends Component
{
    public $districts = [];
    public $sectors = [];
    public $cells = [];
    public $villages = [];

    public $classCategoriesCount = 1;
    public $classCategories = [];

    public $classRoomsCount = 1;

    public $classCategoriesData = [];

    public $classCategoryLevels = [];
    public $classCategoryLevelYears = [];

    public function render()
    {
        return view('livewire.settings.school.info', [
            'provinces' => Province::all(['provincecode', 'provincename'])
        ]);
    }
}
