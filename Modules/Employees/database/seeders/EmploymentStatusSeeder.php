<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Employees\Models\EmploymentStatus;

class EmploymentStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('employment_statuses')) {
            return;
        }

        $statuses = [
            ['name_en' => 'Permanent', 'name_ar' => 'دائم'],
            ['name_en' => 'Contract', 'name_ar' => 'عقد'],
        ];

        foreach ($statuses as $status) {
            EmploymentStatus::query()->updateOrCreate(
                ['name_en' => $status['name_en']],
                [
                    'name_ar' => $status['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

