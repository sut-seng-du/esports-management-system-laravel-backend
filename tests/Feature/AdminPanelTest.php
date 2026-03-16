<?php

namespace Tests\Feature;

use Tests\TestCase;
use OpenAdmin\Admin\Auth\Database\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Disable permission checks for tests
        config(['admin.check_route_permission' => false]);

        // Create an admin user 
        $this->admin = Administrator::create([
            'id'       => 1,
            'username' => 'admin',
            'password' => bcrypt('password'),
            'name'     => 'Administrator',
        ]);

        // Explicitly login to the admin guard
        \OpenAdmin\Admin\Facades\Admin::guard()->login($this->admin);
    }

    /** @test */
    public function admin_can_login_and_see_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function admin_can_see_online_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard/online');

        $response->assertStatus(200);
        $response->assertSee('Online');
    }

    /** @test */
    public function admin_can_see_debt_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard/debt');

        $response->assertStatus(200);
        $response->assertSee('Debt');
    }

    /** @test */
    public function admin_can_see_unpaid_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard/unpaid');

        $response->assertStatus(200);
        $response->assertSee('Unpaid');
    }

    /** @test */
    public function admin_can_see_stock_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard/stock');

        $response->assertStatus(200);
        $response->assertSee('Stock');
    }

    /** @test */
    public function admin_can_see_record_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/records');

        $response->assertStatus(200);
        $response->assertSee('Records');
    }

    /** @test */
    public function admin_can_see_booking_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/bookings');

        $response->assertStatus(200);
        $response->assertSee('Bookings');
    }

    /** @test */
    public function admin_can_see_inventory_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/inventories');

        $response->assertStatus(200);
        $response->assertSee('Inventories');
    }
}
