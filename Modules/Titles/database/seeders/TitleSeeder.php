<?php

namespace Modules\Titles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Titles\Models\Title;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Manager',     'name_ar' => 'مدير',    'department_id' => 1],
            ['name' => 'Accountant',  'name_ar' => 'محاسب',  'department_id' => 2],
            ['name' => 'Sales',       'name_ar' => 'مبيعات', 'department_id' => 3],
            ['name' => 'Engineer',    'name_ar' => 'مهندس',  'department_id' => 4],
            ['name' => 'Technician',  'name_ar' => 'فني',    'department_id' => 4],
        ];
        foreach ($data as $row) {
            Title::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'department_id' => $row['department_id'], 'is_active' => true]
            );
        }
    }
}
