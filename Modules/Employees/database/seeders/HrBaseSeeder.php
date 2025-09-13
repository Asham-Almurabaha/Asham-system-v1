<?php

namespace Modules\Employees\Database\Seeders;

use Illuminate\Database\Seeder;

class HrBaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EmploymentStatusSeeder::class,
            WorkStatusSeeder::class,
            ResidencyStatusSeeder::class,
            SponsorshipStatusSeeder::class,
        ]);
    }
}
