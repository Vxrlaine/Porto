<?php

namespace Tests\Feature;

use App\Models\Commission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function public_user_can_submit_commission_request()
    {
        $commissionData = [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'description' => 'Custom artwork request',
            'character_type' => 'Anime',
            'character_count' => 2,
            'budget' => 100.00,
        ];

        $response = $this->post('/commissions', $commissionData);

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'status' => 'pending',
        ]);
    }

    #[Test]
    public function commission_validation_requires_email()
    {
        $response = $this->post('/commissions', [
            'client_name' => 'John Doe',
            'description' => 'Test commission',
        ]);

        $response->assertSessionHasErrors(['client_email']);
    }

    #[Test]
    public function commission_validation_requires_description()
    {
        $response = $this->post('/commissions', [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors(['description']);
    }

    #[Test]
    public function admin_can_view_all_commissions()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        Commission::create([
            'client_name' => 'Client 1',
            'client_email' => 'client1@example.com',
            'description' => 'Commission 1',
            'status' => 'pending',
        ]);

        Commission::create([
            'client_name' => 'Client 2',
            'client_email' => 'client2@example.com',
            'description' => 'Commission 2',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/commissions');

        $response->assertStatus(200);
        $response->assertViewHas('commissions');
    }

    #[Test]
    public function admin_can_update_commission_status()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $commission = Commission::create([
            'client_name' => 'Client',
            'client_email' => 'client@example.com',
            'description' => 'Test commission',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->patch("/admin/commissions/{$commission->id}/status", [
                'status' => 'accepted',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'id' => $commission->id,
            'status' => 'accepted',
        ]);
    }

    #[Test]
    public function admin_can_assign_commission_to_user()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $commission = Commission::create([
            'client_name' => 'Client',
            'client_email' => 'client@example.com',
            'description' => 'Test commission',
        ]);

        $response = $this->actingAs($admin)
            ->post("/admin/commissions/{$commission->id}/assign", [
                'assigned_to' => $admin->id,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'id' => $commission->id,
            'assigned_to' => $admin->id,
        ]);
    }

    #[Test]
    public function invalid_status_rejected()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $commission = Commission::create([
            'client_name' => 'Client',
            'client_email' => 'client@example.com',
            'description' => 'Test commission',
        ]);

        $response = $this->actingAs($admin)
            ->patch("/admin/commissions/{$commission->id}/status", [
                'status' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors(['status']);
    }
}
