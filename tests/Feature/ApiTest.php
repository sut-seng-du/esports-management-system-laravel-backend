<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use App\Models\Inventory;
use App\Models\Outcome;
use App\Models\Pricing;
use App\Models\Announcement;
use App\Models\Booking;
use App\Models\Seat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_endpoints_work_correctly()
    {
        // Pricing
        Pricing::create(['name' => 'Standard', 'hour' => 1, 'price' => 1000]);
        $this->getJson('/api/pricing')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'name', 'hour', 'price']]]);

        // Announcements
        Announcement::create([
            'title' => 'T1', 'description' => 'D1', 
            'start_datetime' => now(), 'end_datetime' => now()->addHour()
        ]);
        $this->getJson('/api/announcements')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'title', 'description', 'poster_image']]]);

        // Seats
        Seat::create(['code' => 'S1']);
        $this->getJson('/api/seats')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'code']]]);
    }

    /** @test */
    public function user_can_login_and_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);

        $token = $response->json('token');

        $this->withHeader('Authorization', 'Bearer ' . $token)
             ->postJson('/api/logout')
             ->assertStatus(200);
    }

    /** @test */
    public function protected_resource_crud_works_with_auth()
    {
        $user = User::create(['name' => 'A', 'email' => 'a@b.c', 'password' => 'p']);
        Sanctum::actingAs($user);

        // Record CRUD
        $recordResponse = $this->postJson('/api/records', [
            'total' => 100, 'paid' => true, 'online' => false
        ]);
        $recordResponse->assertStatus(201);
        $recordId = $recordResponse->json('data.id');

        $this->getJson('/api/records/' . $recordId)->assertStatus(200);
        $this->putJson('/api/records/' . $recordId, ['total' => 200])->assertStatus(200);
        $this->deleteJson('/api/records/' . $recordId)->assertStatus(200);

        // Inventory CRUD
        $invResponse = $this->postJson('/api/inventories', [
            'item_name' => 'I1', 'qty' => 1, 'price' => 1
        ]);
        $invResponse->assertStatus(201);
        $invId = $invResponse->json('data.id');
        $this->postJson("/api/inventories/{$invId}/quantity", ['qty' => 10])->assertStatus(200);

        // Outcome CRUD
        $outcomeResponse = $this->postJson('/api/outcomes', [
            'description' => 'O1', 'price' => 50
        ]);
        $outcomeResponse->assertStatus(201);

        // Booking CRUD (requires seat IDs and 3-hour duration)
        $seat = Seat::create(['code' => 'B101']);
        $bookingResponse = $this->postJson('/api/bookings', [
            'seats' => [$seat->id],
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '13:00:00', // 3 hours
        ]);
        $bookingResponse->assertStatus(201);
    }

    /** @test */
    public function utility_endpoints_return_correct_data()
    {
        $user = User::create(['name' => 'A', 'email' => 'a@b.c', 'password' => 'p']);
        Sanctum::actingAs($user);

        // Top Members
        Record::create(['member_ID' => 'M1', 'total' => 100, 'paid' => 1, 'online' => 0]);
        $this->getJson('/api/top-members')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [['member_ID', 'total_member_amount']]]);

        // Outcome Total
        Outcome::create(['description' => 'E', 'price' => 100]);
        $this->getJson('/api/outcomes/total')
            ->assertStatus(200)
            ->assertJson(['total' => 100]);

        // Booking Availability (requires start/end time)
        $this->getJson('/api/bookings/availability?date=' . date('Y-m-d') . '&start_time=10:00:00&end_time=13:00:00')
            ->assertStatus(200)
            ->assertJsonStructure(['occupied_seat_ids']);
    }
}
