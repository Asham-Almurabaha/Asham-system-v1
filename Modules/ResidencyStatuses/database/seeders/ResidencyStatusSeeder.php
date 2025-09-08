<?php

namespace Modules\ResidencyStatuses\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ResidencyStatuses\Models\ResidencyStatus;

class ResidencyStatusSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Valid', 'name_ar' => 'سارية'],
            ['name' => 'Expired', 'name_ar' => 'منتهية'],
            ['name' => 'Pending', 'name_ar' => 'قيد المعالجة'],
        ];

        foreach ($data as $row) {
            ResidencyStatus::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}

