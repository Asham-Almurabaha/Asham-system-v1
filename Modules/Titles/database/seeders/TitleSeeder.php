<?php

namespace Modules\Titles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Titles\Models\Title;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Manager',     'name_ar' => 'مدير'],
            ['name' => 'Accountant',  'name_ar' => 'محاسب'],
            ['name' => 'Sales',       'name_ar' => 'مبيعات'],
            ['name' => 'Engineer',    'name_ar' => 'مهندس'],
            ['name' => 'Technician',  'name_ar' => 'فني'],
        ];
        foreach ($data as $row) {
            Title::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}

