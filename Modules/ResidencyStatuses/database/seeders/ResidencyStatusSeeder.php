<?php

namespace Modules\ResidencyStatuses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ResidencyStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('residency_statuses')) {
            return;
        }
        // TODO: seed residency statuses
    }
}

