<?php

namespace Modules\WorkStatuses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\WorkStatuses\Models\WorkStatus;

class WorkStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('work_statuses')) {
            return;
        }

        $data = [
            ['name' => 'Active', 'name_ar' => 'نشط'],
            ['name' => 'On Leave', 'name_ar' => 'في إجازة'],
            ['name' => 'Resigned', 'name_ar' => 'مستقيل'],
        ];

        foreach ($data as $row) {
            WorkStatus::firstOrCreate(
                ['name' => $row['name']],
                ['name_ar' => $row['name_ar'], 'is_active' => true]
            );
        }
    }
}

