<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Employees\Models\SponsorshipStatus;

class SponsorshipStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('sponsorship_statuses')) {
            return;
        }

        $statuses = [
            ['name_en' => 'Company', 'name_ar' => 'شركة'],
            ['name_en' => 'Self', 'name_ar' => 'ذاتي'],
        ];

        foreach ($statuses as $status) {
            SponsorshipStatus::query()->updateOrCreate(
                ['name_en' => $status['name_en']],
                [
                    'name_ar' => $status['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

