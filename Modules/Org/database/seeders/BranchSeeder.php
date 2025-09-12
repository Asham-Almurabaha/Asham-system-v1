<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Company;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('branches')) {
            return;
        }

        $company = Company::query()->first();
        if (!$company) {
            return;
        }

        Branch::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'name_en' => 'Main Branch',
            ],
            [
                'name_ar' => 'الفرع الرئيسي',
                'is_active' => true,
            ]
        );
    }
}
