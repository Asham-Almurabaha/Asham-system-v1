<?php

namespace Modules\Motorcycles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Motorcycles\Entities\Motorcycle;
use Modules\Motorcycles\Entities\MotorcycleStatus;
use Modules\Org\Models\Branch;

class MotorcycleSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::query()->first();

        Motorcycle::firstOrCreate(
            ['plate_number' => 'MOTO-001'],
            [
                'status' => MotorcycleStatus::AVAILABLE,
                'brand' => 'Yamaha',
                'model' => 'MT-07',
                'branch_id' => $branch?->id,
            ]
        );
    }
}
