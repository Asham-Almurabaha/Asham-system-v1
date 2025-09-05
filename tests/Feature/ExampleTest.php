<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The root route redirects to registration when no users exist.
     */
    public function test_the_application_redirects_to_registration(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('register'));
    }
}
