<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Company;
use Modules\Org\Models\Department;
use Modules\Org\Models\Job;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('jobs')) {
            return;
        }

        $company = Company::query()->first();
        $branch = Branch::query()->first();
        $department = Department::query()->first();

        if (!$company || !$branch || !$department) {
            return;
        }

        Job::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'branch_id' => $branch->id,
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
