<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Announcement;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\Outcome;
use App\Models\Pricing;
use App\Models\Record;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function announcement_can_be_instantiated()
    {
        $announcement = new Announcement();
        $this->assertInstanceOf(Announcement::class, $announcement);
    }

    /** @test */
    public function inventory_can_be_instantiated()
    {
        $inventory = new Inventory();
        $this->assertInstanceOf(Inventory::class, $inventory);
    }

    /** @test */
    public function outcome_can_be_instantiated()
    {
        $outcome = new Outcome();
        $this->assertInstanceOf(Outcome::class, $outcome);
    }

    /** @test */
    public function pricing_can_be_instantiated()
    {
        $pricing = new Pricing();
        $this->assertInstanceOf(Pricing::class, $pricing);
    }

    /** @test */
    public function seat_can_be_instantiated()
    {
        $seat = new Seat();
        $this->assertInstanceOf(Seat::class, $seat);
    }

    /** @test */
    public function user_can_be_instantiated()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

     /** @test */
    public function record_can_be_instantiated()
    {
        $record = new Record();
        $this->assertInstanceOf(Record::class, $record);
    }

    /** @test */
    public function booking_can_be_instantiated()
    {
        $booking = new Booking();
        $this->assertInstanceOf(Booking::class, $booking);
    }

    /** @test */
    public function announcement_can_be_saved()
    {
        $announcement = Announcement::create([
            'title' => 'Tournament',
            'description' => 'E-sports event',
            'start_datetime' => '2026-03-20 10:00:00',
            'end_datetime' => '2026-03-20 20:00:00',
            'active' => 1
        ]);

        $this->assertDatabaseHas('announcements', ['title' => 'Tournament']);
    }

    /** @test */
    public function announcement_can_be_updated()
    {
        $announcement = Announcement::create([
            'title' => 'Old Title',
            'description' => 'Desc',
            'start_datetime' => now(),
            'end_datetime' => now()->addHours(1),
        ]);
        $announcement->update(['title' => 'New Title']);
        $this->assertDatabaseHas('announcements', ['id' => $announcement->id, 'title' => 'New Title']);
    }

    /** @test */
    public function announcement_can_be_deleted()
    {
        $announcement = Announcement::create(['title' => 'Delete Me', 'description' => 'D', 'start_datetime' => now(), 'end_datetime' => now()]);
        $announcement->delete();
        $this->assertDatabaseMissing('announcements', ['id' => $announcement->id]);
    }

    /** @test */
    public function inventory_can_be_saved()
    {
        $inventory = Inventory::create(['item_name' => 'Coca Cola', 'qty' => 10, 'price' => 1500, 'type' => 'Drink']);
        $this->assertDatabaseHas('inventories', ['item_name' => 'Coca Cola']);
    }

    /** @test */
    public function inventory_can_be_updated()
    {
        $inventory = Inventory::create(['item_name' => 'Pepsi', 'qty' => 5, 'price' => 1500, 'type' => 'Drink']);
        $inventory->update(['qty' => 20]);
        $this->assertDatabaseHas('inventories', ['id' => $inventory->id, 'qty' => 20]);
    }

    /** @test */
    public function inventory_can_be_deleted()
    {
        $inventory = Inventory::create(['item_name' => 'Temp', 'qty' => 1, 'price' => 1, 'type' => 'Food']);
        $inventory->delete();
        $this->assertDatabaseMissing('inventories', ['id' => $inventory->id]);
    }

    /** @test */
    public function outcome_can_be_saved()
    {
        $outcome = Outcome::create(['description' => 'Electricity Bill', 'price' => 50000]);
        $this->assertDatabaseHas('outcomes', ['description' => 'Electricity Bill']);
    }

    /** @test */
    public function outcome_can_be_updated()
    {
        $outcome = Outcome::create(['description' => 'Rent', 'price' => 100000]);
        $outcome->update(['price' => 120000]);
        $this->assertDatabaseHas('outcomes', ['id' => $outcome->id, 'price' => 120000]);
    }

    /** @test */
    public function outcome_can_be_deleted()
    {
        $outcome = Outcome::create(['description' => 'Repair', 'price' => 500]);
        $outcome->delete();
        $this->assertDatabaseMissing('outcomes', ['id' => $outcome->id]);
    }

    /** @test */
    public function pricing_can_be_saved()
    {
        $pricing = Pricing::create(['name' => 'VIP', 'hour' => 1, 'price' => 2500]);
        $this->assertDatabaseHas('pricings', ['name' => 'VIP']);
    }

    /** @test */
    public function pricing_can_be_updated()
    {
        $pricing = Pricing::create(['name' => 'Normal', 'hour' => 1, 'price' => 1000]);
        $pricing->update(['price' => 1200]);
        $this->assertDatabaseHas('pricings', ['id' => $pricing->id, 'price' => 1200]);
    }

    /** @test */
    public function pricing_can_be_deleted()
    {
        $pricing = Pricing::create(['name' => 'Discount', 'hour' => 1, 'price' => 500]);
        $pricing->delete();
        $this->assertDatabaseMissing('pricings', ['id' => $pricing->id]);
    }

    /** @test */
    public function seat_can_be_saved()
    {
        $seat = Seat::create(['code' => 'B5']);
        $this->assertDatabaseHas('seats', ['code' => 'B5']);
    }

    /** @test */
    public function seat_can_be_updated()
    {
        $seat = Seat::create(['code' => 'C1']);
        $seat->update(['code' => 'C2']);
        $this->assertDatabaseHas('seats', ['id' => $seat->id, 'code' => 'C2']);
    }

    /** @test */
    public function seat_can_be_deleted()
    {
        $seat = Seat::create(['code' => 'D1']);
        $seat->delete();
        $this->assertDatabaseMissing('seats', ['id' => $seat->id]);
    }

    /** @test */
    public function user_can_be_saved()
    {
        $user = User::create(['name' => 'Alice', 'email' => 'alice@example.com', 'password' => bcrypt('secret')]);
        $this->assertDatabaseHas('users', ['email' => 'alice@example.com']);
    }

    /** @test */
    public function user_can_be_updated()
    {
        $user = User::create(['name' => 'Bob', 'email' => 'bob@example.com', 'password' => bcrypt('secret')]);
        $user->update(['name' => 'Robert']);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Robert']);
    }

    /** @test */
    public function user_can_be_deleted()
    {
        $user = User::create(['name' => 'Eve', 'email' => 'eve@example.com', 'password' => bcrypt('secret')]);
        $user->delete();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function record_can_be_saved()
    {
        $record = Record::create([
            'seat' => 'A1',
            'member_ID' => 'M001',
            'member_amount' => 1000,
            'order' => 'Coffee',
            'order_amount' => 500,
            'total' => 1500,
            'paid' => 1,
            'online' => 0,
            'debt' => 0,
            'created_date' => date('Y-m-d')
        ]);

        $this->assertDatabaseHas('records', [
            'member_ID' => 'M001'
        ]);
    }

    /** @test */
    public function record_can_be_updated()
    {
        $record = Record::create([
            'seat' => 'A1',
            'member_ID' => 'M001',
            'total' => 1000,
            'paid' => 1,
            'online' => 0,
            'created_date' => date('Y-m-d')
        ]);

        $record->update(['total' => 2000]);

        $this->assertDatabaseHas('records', [
            'id' => $record->id,
            'total' => 2000
        ]);
    }

    /** @test */
    public function record_can_be_deleted()
    {
        $record = Record::create([
            'seat' => 'A1',
            'member_ID' => 'M001',
            'total' => 1000,
            'paid' => 1,
            'online' => 0,
            'created_date' => date('Y-m-d')
        ]);

        $record->delete();

        $this->assertDatabaseMissing('records', [
            'id' => $record->id
        ]);
    }

    /** @test */
    public function booking_can_be_saved()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'confirmed' => 0
        ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function booking_can_be_updated()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'test_update@example.com',
            'password' => bcrypt('password')
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'confirmed' => 0
        ]);

        $booking->update(['confirmed' => 1]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'confirmed' => 1
        ]);
    }

    /** @test */
    public function booking_can_be_deleted()
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'test_delete@example.com',
            'password' => bcrypt('password')
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'confirmed' => 0
        ]);

        $booking->delete();

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id
        ]);
    }

    /** @test */
    public function record_can_be_retrieved_by_id()
    {
        $record = Record::create([
            'seat' => 'A1',
            'member_ID' => 'M999',
            'total' => 100,
            'paid' => 1,
            'online' => 0,
            'created_date' => date('Y-m-d')
        ]);

        $found = Record::find($record->id);
        $this->assertEquals('M999', $found->member_ID);
    }

    /** @test */
    public function record_collection_can_be_listed()
    {
        Record::create(['seat' => 'A1', 'member_ID' => 'M1', 'total' => 10, 'paid' => 1, 'online' => 0]);
        Record::create(['seat' => 'A2', 'member_ID' => 'M2', 'total' => 20, 'paid' => 1, 'online' => 0]);

        $records = Record::all();
        $this->assertGreaterThanOrEqual(2, $records->count());
    }

    /** @test */
    public function booking_can_be_retrieved_by_id()
    {
        $user = User::create(['name' => 'U', 'email' => 'u@e.c', 'password' => 'p']);
        $booking = Booking::create([
            'user_id' => $user->id,
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'confirmed' => 0
        ]);

        $found = Booking::find($booking->id);
        $this->assertEquals($user->id, $found->user_id);
    }

    /** @test */
    public function booking_collection_can_be_listed()
    {
        $user = User::create(['name' => 'U', 'email' => 'u2@e.c', 'password' => 'p']);
        Booking::create(['user_id' => $user->id, 'date' => date('Y-m-d'), 'start_time' => '10', 'end_time' => '12', 'confirmed' => 0]);
        
        $bookings = Booking::all();
        $this->assertGreaterThanOrEqual(1, $bookings->count());
    }

    /** @test */
    public function announcement_can_be_retrieved_by_id()
    {
        $ann = Announcement::create(['title' => 'ShowMe', 'description' => 'D', 'start_datetime' => now(), 'end_datetime' => now()]);
        $found = Announcement::find($ann->id);
        $this->assertEquals('ShowMe', $found->title);
    }

    /** @test */
    public function inventory_can_be_retrieved_by_id()
    {
        $inv = Inventory::create(['item_name' => 'Item1', 'qty' => 10, 'price' => 100, 'type' => 'T']);
        $found = Inventory::find($inv->id);
        $this->assertEquals('Item1', $found->item_name);
    }

    /** @test */
    public function outcome_can_be_retrieved_by_id()
    {
        $out = Outcome::create(['description' => 'Out1', 'price' => 100]);
        $found = Outcome::find($out->id);
        $this->assertEquals('Out1', $found->description);
    }

    /** @test */
    public function pricing_can_be_retrieved_by_id()
    {
        $pri = Pricing::create(['name' => 'P1', 'hour' => 1, 'price' => 100]);
        $found = Pricing::find($pri->id);
        $this->assertEquals('P1', $found->name);
    }

    /** @test */
    public function seat_can_be_retrieved_by_id()
    {
        $seat = Seat::create(['code' => 'S100']);
        $found = Seat::find($seat->id);
        $this->assertEquals('S100', $found->code);
    }

    /** @test */
    public function user_can_be_retrieved_by_id()
    {
        $user = User::create(['name' => 'U1', 'email' => 'u1@x.c', 'password' => 'p']);
        $found = User::find($user->id);
        $this->assertEquals('U1', $found->name);
    }

    /** @test */
    public function all_models_can_be_listed()
    {
        $this->assertGreaterThanOrEqual(0, Announcement::all()->count());
        $this->assertGreaterThanOrEqual(0, Inventory::all()->count());
        $this->assertGreaterThanOrEqual(0, Outcome::all()->count());
        $this->assertGreaterThanOrEqual(0, Pricing::all()->count());
        $this->assertGreaterThanOrEqual(0, Seat::all()->count());
        $this->assertGreaterThanOrEqual(0, User::all()->count());
    }
}
