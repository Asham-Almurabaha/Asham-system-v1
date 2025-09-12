<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('jobs')) {
            return;
        }
        // TODO: seed jobs
    }
}
