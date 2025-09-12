<?php

namespace Modules\Phones\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Phones\Entities\Phone;
use Modules\Phones\Entities\PhoneStatus;
use Modules\Org\Models\Branch;

class PhoneSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::query()->first();

        Phone::firstOrCreate(
            ['imei' => '123456789012345'],
            [
                'status' => PhoneStatus::AVAILABLE,
                'brand' => 'Apple',
                'model' => 'iPhone',
                'branch_id' => $branch?->id,
            ]
        );
    }
}
