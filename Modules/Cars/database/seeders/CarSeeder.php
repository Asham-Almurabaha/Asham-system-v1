<?php

namespace Modules\Cars\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\CarStatus;
use Modules\Org\Models\Branch;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CarLookupSeeder::class);

        $branch = Branch::query()->first();

        Car::firstOrCreate(
            ['plate_number' => 'CAR-001'],
            [
                'status' => CarStatus::AVAILABLE,
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'branch_id' => $branch?->id,
            ]
        );
    }
}
