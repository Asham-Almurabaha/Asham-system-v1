<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('departments')) {
            return;
        }
        // TODO: seed departments
    }
}
