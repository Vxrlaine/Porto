<?php

namespace Tests\Unit;

use App\Models\Commission;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    #[Test]
    public function it_can_create_a_commission()
    {
        $commission = Commission::create([
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'description' => 'Custom character artwork',
            'character_type' => 'Anime',
            'character_count' => 2,
            'budget' => 150.00,
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(Commission::class, $commission);
        $this->assertEquals('John Doe', $commission->client_name);
        $this->assertEquals('pending', $commission->status);
    }

    #[Test]
    public function it_has_default_status_of_pending()
    {
        $commission = Commission::create([
            'client_name' => 'Jane Smith',
            'client_email' => 'jane@example.com',
            'description' => 'Portrait artwork',
        ]);

        $this->assertEquals('pending', $commission->status);
    }

    #[Test]
    public function it_can_get_status_color()
    {
        $commission = new Commission();
        $commission->status = 'pending';
        
        $this->assertEquals('yellow', $commission->status_color);

        $commission->status = 'completed';
        $this->assertEquals('emerald', $commission->status_color);

        $commission->status = 'rejected';
        $this->assertEquals('red', $commission->status_color);
    }

    #[Test]
    public function it_can_be_assigned_to_user()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $commission = Commission::create([
            'client_name' => 'Client',
            'client_email' => 'client@example.com',
            'description' => 'Test commission',
            'assigned_to' => $admin->id,
        ]);

        $this->assertEquals($admin->id, $commission->assigned_to);
        $this->assertInstanceOf(User::class, $commission->assignedUser);
    }

    #[Test]
    public function it_casts_character_count_to_integer()
    {
        $commission = Commission::create([
            'client_name' => 'Test',
            'client_email' => 'test@example.com',
            'description' => 'Test',
            'character_count' => '5',
        ]);

        $this->assertIsInt($commission->character_count);
        $this->assertEquals(5, $commission->character_count);
    }
}
