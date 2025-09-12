<?php

namespace Modules\Assets\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Assets\Models\Asset;

class AssetDemoSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: seed demo assets only in demo environment
        if (app()->environment('demo')) {
            Asset::factory()->count(5)->create();
        }
    }
}
