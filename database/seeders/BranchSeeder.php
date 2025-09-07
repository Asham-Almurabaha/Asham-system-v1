<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\City;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $riyadh = City::firstOrCreate(
            ['name' => 'Riyadh'],
            ['name_ar' => 'الرياض', 'is_active' => true]
        );
        $jeddah = City::firstOrCreate(
            ['name' => 'Jeddah'],
            ['name_ar' => 'جدة', 'is_active' => true]
        );

        $data = [
            ['name' => 'Administration', 'name_ar' => 'الإدارة', 'city_id' => $riyadh->id],
            ['name' => 'Jeddah Branch',  'name_ar' => 'فرع جدة',   'city_id' => $jeddah->id],
        ];

        foreach ($data as $row) {
            Branch::firstOrCreate(
                ['name' => $row['name']],
                [
                    'name_ar' => $row['name_ar'],
                    'city_id' => $row['city_id'],
                    'is_active' => true,
                ]
            );
        }
    }
}

