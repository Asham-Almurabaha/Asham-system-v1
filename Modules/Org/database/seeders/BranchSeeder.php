<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('branches')) {
            return;
        }
        // TODO: seed branches
    }
}
