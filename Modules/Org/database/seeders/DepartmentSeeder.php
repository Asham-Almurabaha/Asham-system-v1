<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('departments')) {
            return;
        }

        Department::query()->updateOrCreate(
            [
                'name_en' => 'Human Resources',
            ],
            [
                'name_ar' => 'الموارد البشرية',
                'is_active' => true,
            ]
        );
    }
}
