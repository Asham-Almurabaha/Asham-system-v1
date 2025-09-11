<?php

namespace Modules\Cities\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Cities\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('cities')) {
            return;
        }

        $data = [
            ['name' => 'Riyadh',  'name_ar' => 'الرياض'],
            ['name' => 'Jeddah',  'name_ar' => 'جدة'],
            ['name' => 'Dammam',  'name_ar' => 'الدمام'],
        ];

        foreach ($data as $row) {
            City::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}

