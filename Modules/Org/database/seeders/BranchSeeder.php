<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Company;
use Modules\Org\Models\City;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('branches')) {
            return;
        }

        $company = Company::query()->first();
        $city = City::query()->first();

        if (!$company || !$city) {
            return;
        }

        Branch::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'name_en' => 'Main Branch',
            ],
            [
                'name_ar' => 'الفرع الرئيسي',
                'city_id' => $city->id,
                'is_active' => true,
            ]
        );
    }
}
