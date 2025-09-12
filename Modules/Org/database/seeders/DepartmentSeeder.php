<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Company;
use Modules\Org\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('departments')) {
            return;
        }

        $company = Company::query()->first();
        $branch = Branch::query()->first();

        if (!$company || !$branch) {
            return;
        }

        Department::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'branch_id' => $branch->id,
                'name_en' => 'Human Resources',
            ],
            [
                'name_ar' => 'الموارد البشرية',
                'is_active' => true,
            ]
        );
    }
}
