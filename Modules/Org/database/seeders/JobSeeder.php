<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Department;
use Modules\Org\Models\Job;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('jobs')) {
            return;
        }

        $department = Department::query()->first();

        if (!$department) {
            return;
        }

        Job::query()->updateOrCreate(
            [
                'department_id' => $department->id,
                'name_en' => 'Manager',
            ],
            [
                'name_ar' => 'مدير',
                'is_active' => true,
            ]
        );
    }
}
