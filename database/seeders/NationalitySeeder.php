<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Egyptian', 'name_ar' => 'مصري'],
            ['name' => 'Saudi',    'name_ar' => 'سعودي'],
            ['name' => 'Jordanian','name_ar' => 'أردني'],
            ['name' => 'Syrian',   'name_ar' => 'سوري'],
            ['name' => 'Sudanese', 'name_ar' => 'سوداني'],
        ];
        foreach ($data as $row) {
            Nationality::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}

