<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_users_resource(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_premium_templates_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/premium-templates');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_premium_templates_for_specific_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/premium-templates?user_id=' . $user->id);

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_api_tester_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/api-tester');

        $response->assertStatus(200);
    }

    public function test_api_v1_health_endpoint(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'version' => '1.0.0',
            ]);
    }
}

