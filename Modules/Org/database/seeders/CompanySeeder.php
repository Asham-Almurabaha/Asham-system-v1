<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('companies')) {
            return;
        }

        Company::query()->updateOrCreate(
            ['name_en' => 'Demo Company'],
            [
                'name_ar' => 'شركة تجريبية',
                'cr_number' => 'CR123456',
                'vat_number' => 'VAT123456',
                'iban' => 'SA1234567890123456789012',
            ]
        );
    }
}
