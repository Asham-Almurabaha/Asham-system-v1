<?php

namespace Modules\Departments\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Departments\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Human Resources', 'name_ar' => 'الموارد البشرية'],
            ['name' => 'Finance', 'name_ar' => 'المالية'],
            ['name' => 'Sales', 'name_ar' => 'المبيعات'],
            ['name' => 'Engineering', 'name_ar' => 'الهندسة'],
        ];
        foreach ($data as $row) {
            Department::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}
