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

        $data = [
            ['name_en' => 'Main Company', 'name_ar' => 'الشركة الرئيسية', 'cr_number' => '12345', 'vat_number' => '54321', 'iban' => 'SA000000000'],
        ];

        foreach ($data as $row) {
            Company::firstOrCreate(
                ['name_en' => $row['name_en']],
                $row
            );
        }
    }
}
