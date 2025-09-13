<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Employees\Models\ResidencyStatus;

class ResidencyStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('residency_statuses')) {
            return;
        }

        $statuses = [
            ['name_en' => 'Resident', 'name_ar' => 'مقيم'],
            ['name_en' => 'Non-Resident', 'name_ar' => 'غير مقيم'],
        ];

        foreach ($statuses as $status) {
            ResidencyStatus::query()->updateOrCreate(
                ['name_en' => $status['name_en']],
                [
                    'name_ar' => $status['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

