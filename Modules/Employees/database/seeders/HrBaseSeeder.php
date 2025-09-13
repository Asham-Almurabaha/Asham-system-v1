<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;

class HrBaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WorkStatusSeeder::class,
            ResidencyStatusSeeder::class,
        ]);
    }
}
