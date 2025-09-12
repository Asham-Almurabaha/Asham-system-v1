<?php

namespace Modules\Cars\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\CarAssignment;
use Modules\Cars\Entities\CarStatus;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_and_updates_car(): void
    {
        $car = Car::create(['plate_number' => 'ا1234', 'status' => CarStatus::AVAILABLE]);
        $this->assertDatabaseHas('cars', ['plate_number' => 'ا1234']);
        $car->update(['brand' => 'Toyota']);
        $this->assertDatabaseHas('cars', ['brand' => 'Toyota']);
    }

    /** @test */
    public function cannot_delete_car_with_active_assignment(): void
    {
        $car = Car::create(['plate_number' => 'ب1234', 'status' => CarStatus::AVAILABLE]);
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
        $car = Car::create(['plate_number' => 'ت1234', 'status' => CarStatus::AVAILABLE]);
        $car->assignments()->create([
            'employee_id' => 1,
            'assigned_at' => now(),
            'condition_on_assign' => 'good'
        ]);
        $this->assertEquals(CarStatus::ASSIGNED, $car->fresh()->status);
    }
}
