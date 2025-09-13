<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Employees\Models\WorkStatus;

class WorkStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('work_statuses')) {
            return;
        }

        $statuses = [
            ['name_en' => 'Active', 'name_ar' => 'نشط'],
            ['name_en' => 'Terminated', 'name_ar' => 'منتهي'],
        ];

        foreach ($statuses as $status) {
            WorkStatus::query()->updateOrCreate(
                ['name_en' => $status['name_en']],
                [
                    'name_ar' => $status['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

