<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WorkStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('work_statuses')) {
            return;
        }
        // TODO: seed work statuses
    }
}

