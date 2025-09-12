<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('cities')) {
            return;
        }

        $cities = [
            ['name_en' => 'Riyadh', 'name_ar' => 'الرياض'],
            ['name_en' => 'Jeddah', 'name_ar' => 'جدة'],
            ['name_en' => 'Dammam', 'name_ar' => 'الدمام'],
        ];

        foreach ($cities as $city) {
            City::query()->updateOrCreate(
                ['name_en' => $city['name_en']],
                [
                    'name_ar' => $city['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

