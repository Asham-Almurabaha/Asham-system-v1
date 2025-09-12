<?php

namespace Modules\Phones\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Phones\Entities\Phone;
use Modules\Phones\Entities\PhoneStatus;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_and_updates_phone(): void
    {
        $p = Phone::create(['imei' => '123456789012345', 'status' => PhoneStatus::AVAILABLE]);
        $this->assertDatabaseHas('phones', ['imei' => '123456789012345']);
        $p->update(['brand' => 'Apple']);
        $this->assertDatabaseHas('phones', ['brand' => 'Apple']);
    }

    /** @test */
    public function cannot_delete_phone_with_active_assignment(): void
    {
        $p = Phone::create(['imei' => '999456789012345', 'status' => PhoneStatus::AVAILABLE]);
        $p->assignments()->create([
            'employee_id' => 1,
            'assigned_at' => now(),
            'condition_on_assign' => 'good'
        ]);
        $response = $this->delete(route('phones.destroy',$p));
        $this->assertDatabaseHas('phones', ['id' => $p->id]);
    }
}
