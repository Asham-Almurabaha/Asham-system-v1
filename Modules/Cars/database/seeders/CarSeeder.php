<?php

namespace Modules\Cars\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\Lookups\{CarBrand, CarColor, CarModel, CarStatus, CarType, CarYear};
use Modules\Org\Models\Branch;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CarLookupSeeder::class);

        $branch = Branch::query()->first();

        $status = CarStatus::where('name_en', 'available')->first();
        $type = CarType::first();
        $brand = CarBrand::where('car_type_id', $type?->id)->first();
        $model = CarModel::where('car_brand_id', $brand?->id)->first();
        $year = CarYear::first();
        $color = CarColor::first();

        Car::firstOrCreate(
            ['plate_letters' => 'أبج', 'plate_numbers' => '0001'],
            [
                'sequence_number' => 'SEQ-001',
                'car_status_id' => $status?->id,
                'car_type_id' => $type?->id,
                'car_brand_id' => $brand?->id,
                'car_model_id' => $model?->id,
                'car_year_id' => $year?->id,
                'car_color_id' => $color?->id,
                'branch_id' => $branch?->id,
            ]
        );
    }
}
