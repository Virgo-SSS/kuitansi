<?php

namespace Tests\Feature;

use App\Http\Livewire\DashboardData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_guest_cant_load_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(302);
    }

    public function test_user_can_load_dashboard(): void
    {
        $this->actingAs($user = $this->createUser('user'));

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertViewIs('dashboard.index')
            ->assertSeeLivewire(DashboardData::class);
    }
}
