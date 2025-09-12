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

        $company = Company::first();
        if (!$company) {
            return;
        }

        $data = [
            ['company_id' => $company->id, 'name_en' => 'Main Branch', 'name_ar' => 'الفرع الرئيسي', 'is_active' => true],
        ];

        foreach ($data as $row) {
            Branch::firstOrCreate(
                ['name_en' => $row['name_en']],
                $row
            );
        }
    }
}
