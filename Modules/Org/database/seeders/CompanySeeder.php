<?php

namespace Modules\Org\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('companies')) {
            return;
        }
        // TODO: seed companies
    }
}
