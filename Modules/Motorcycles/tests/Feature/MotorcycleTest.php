<?php

namespace Modules\Motorcycles\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Motorcycles\Entities\Motorcycle;
use Modules\Motorcycles\Entities\MotorcycleStatus;
use Tests\TestCase;

class MotorcycleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_and_updates_motorcycle(): void
    {
        $m = Motorcycle::create(['plate_number' => 'ا1234', 'status' => MotorcycleStatus::AVAILABLE]);
        $this->assertDatabaseHas('motorcycles', ['plate_number' => 'ا1234']);
        $m->update(['brand' => 'Yamaha']);
        $this->assertDatabaseHas('motorcycles', ['brand' => 'Yamaha']);
    }

    /** @test */
    public function cannot_delete_motorcycle_with_active_assignment(): void
    {
        $m = Motorcycle::create(['plate_number' => 'ب1234', 'status' => MotorcycleStatus::AVAILABLE]);
        $m->assignments()->create([
            'employee_id' => 1,
            'assigned_at' => now(),
            'condition_on_assign' => 'good'
        ]);
        $response = $this->delete(route('motorcycles.destroy',$m));
        $this->assertDatabaseHas('motorcycles', ['id' => $m->id]);
    }
}
