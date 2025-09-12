<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('employees')) {
            return; // TODO: ensure employees table exists
        }
        // TODO: seed employees data
    }
}
