<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Job;
use Modules\Org\Models\Company;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('jobs')) {
            return;
        }

        $company = Company::first();
        $branch = Branch::first();
        $department = Department::first();
        if (!$company || !$branch || !$department) {
            return;
        }

        $data = [
            ['company_id' => $company->id, 'branch_id' => $branch->id, 'department_id' => $department->id, 'name_en' => 'Manager', 'name_ar' => 'مدير', 'is_active' => true],
        ];

        foreach ($data as $row) {
            Job::firstOrCreate(
                ['name_en' => $row['name_en']],
                $row
            );
        }
    }
}
