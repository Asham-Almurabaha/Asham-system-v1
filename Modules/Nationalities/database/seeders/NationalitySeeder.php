<?php

namespace Modules\Nationalities\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('nationalities')) {
            return;
        }
        // TODO: seed nationalities
    }
}

