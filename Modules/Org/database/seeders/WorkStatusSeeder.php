<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\WorkStatus;

class WorkStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('work_statuses')) {
            return;
        }

        $statuses = [
            ['code' => 'active', 'name_en' => 'Active', 'name_ar' => 'نشط'],
            ['code' => 'terminated', 'name_en' => 'Terminated', 'name_ar' => 'منتهي'],
        ];

        foreach ($statuses as $status) {
            WorkStatus::query()->updateOrCreate(
                ['code' => $status['code']],
                [
                    'name_en' => $status['name_en'],
                    'name_ar' => $status['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

