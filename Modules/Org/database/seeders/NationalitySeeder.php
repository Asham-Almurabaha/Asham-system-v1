<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Modules\Org\Models\Nationality;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('nationalities')) {
            return;
        }

        $nationalities = [
            ['name_en' => 'Saudi', 'name_ar' => 'سعودي'],
            ['name_en' => 'Egyptian', 'name_ar' => 'مصري'],
            ['name_en' => 'Indian', 'name_ar' => 'هندي'],
        ];

        foreach ($nationalities as $nationality) {
            Nationality::query()->updateOrCreate(
                ['name_en' => $nationality['name_en']],
                [
                    'name_ar' => $nationality['name_ar'],
                    'is_active' => true,
                ]
            );
        }
    }
}

