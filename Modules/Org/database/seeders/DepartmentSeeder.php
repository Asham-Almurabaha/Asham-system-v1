<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Department;
use Modules\Org\Models\Company;
use Modules\Org\Models\Branch;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('departments')) {
            return;
        }

        $company = Company::first();
        $branch = Branch::first();
        if (!$company || !$branch) {
            return;
        }

        $data = [
            ['company_id' => $company->id, 'branch_id' => $branch->id, 'name_en' => 'General Dept', 'name_ar' => 'القسم العام', 'is_active' => true],
        ];

        foreach ($data as $row) {
            Department::firstOrCreate(
                ['name_en' => $row['name_en']],
                $row
            );
        }
    }
}
