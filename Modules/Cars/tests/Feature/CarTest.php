<?php

namespace Modules\Cars\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Cars\Database\Seeders\CarLookupSeeder;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\CarAssignment;
use Modules\Cars\Entities\Lookups\{CarBrand, CarColor, CarModel, CarStatus, CarType, CarYear};
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_and_updates_car(): void
    {
        $this->seed(CarLookupSeeder::class);
        $status = CarStatus::where('name_en', 'available')->first();
        $type = CarType::first();
        $brand = CarBrand::where('car_type_id', $type->id)->first();
        $model = CarModel::where('car_brand_id', $brand->id)->first();
        $year = CarYear::first();
        $color = CarColor::first();

        $car = Car::create([
            'sequence_number' => '123456',
            'plate_letters' => 'ا',
            'plate_numbers' => '1234',
            'car_status_id' => $status->id,
            'car_type_id' => $type->id,
            'car_brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'car_year_id' => $year->id,
            'car_color_id' => $color->id,
        ]);
        $this->assertDatabaseHas('cars', ['plate_letters' => 'ا', 'plate_numbers' => '1234']);
        $newBrand = CarBrand::where('id', '!=', $brand->id)->first();
        $car->update(['car_brand_id' => $newBrand->id]);
        $this->assertDatabaseHas('cars', ['car_brand_id' => $newBrand->id]);
    }

    /** @test */
    public function cannot_delete_car_with_active_assignment(): void
    {
        $this->seed(CarLookupSeeder::class);
        $status = CarStatus::where('name_en', 'available')->first();
        $type = CarType::first();
        $brand = CarBrand::where('car_type_id', $type->id)->first();
        $model = CarModel::where('car_brand_id', $brand->id)->first();
        $year = CarYear::first();
        $color = CarColor::first();
        $car = Car::create([
            'sequence_number' => '234567',
            'plate_letters' => 'ب',
            'plate_numbers' => '1234',
            'car_status_id' => $status->id,
            'car_type_id' => $type->id,
            'car_brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'car_year_id' => $year->id,
            'car_color_id' => $color->id,
        ]);
        $car->assignments()->create([
            'employee_id' => 1,
            'assigned_at' => now(),
            'condition_on_assign' => 'good'
        ]);
        $response = $this->delete(route('cars.destroy',$car));
        $this->assertDatabaseHas('cars', ['id' => $car->id]);
    }

    /** @test */
    public function assignment_flow(): void
    {
        $this->seed(CarLookupSeeder::class);
        $status = CarStatus::where('name_en', 'available')->first();
        $type = CarType::first();
        $brand = CarBrand::where('car_type_id', $type->id)->first();
        $model = CarModel::where('car_brand_id', $brand->id)->first();
        $year = CarYear::first();
        $color = CarColor::first();
        $car = Car::create([
            'sequence_number' => '345678',
            'plate_letters' => 'ت',
            'plate_numbers' => '1234',
            'car_status_id' => $status->id,
            'car_type_id' => $type->id,
            'car_brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'car_year_id' => $year->id,
            'car_color_id' => $color->id,
        ]);
        $car->assignments()->create([
            'employee_id' => 1,
            'assigned_at' => now(),
            'condition_on_assign' => 'good'
        ]);
        $assigned = CarStatus::where('name_en', 'assigned')->first();
        $this->assertEquals($assigned->id, $car->fresh()->car_status_id);
    }
}
