<?php

namespace Modules\Cities\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('cities')) {
            return;
        }
        // TODO: seed cities data
    }
}

