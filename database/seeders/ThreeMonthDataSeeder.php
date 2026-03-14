<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seat;
use App\Models\Record;
use App\Models\Booking;
use App\Models\Outcome;
use App\Models\Inventory;
use App\Models\Pricing;
use Carbon\Carbon;

class ThreeMonthDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Base Data
        if (User::count() == 0) {
            User::factory(10)->create();
        }

        if (Seat::count() == 0) {
            foreach (range('A', 'D') as $row) {
                foreach (range(1, 10) as $num) {
                    Seat::create(['code' => $row . $num]);
                }
            }
        }

        if (Inventory::count() == 0) {
            $items = [
                ['item_name' => 'Coca Cola', 'qty' => 50, 'price' => 1500, 'type' => 'Drink'],
                ['item_name' => 'Pepsi', 'qty' => 50, 'price' => 1500, 'type' => 'Drink'],
                ['item_name' => 'Red Bull', 'qty' => 30, 'price' => 3500, 'type' => 'Drink'],
                ['item_name' => 'Classic Burger', 'qty' => 20, 'price' => 4500, 'type' => 'Food'],
                ['item_name' => 'Fried Noodles', 'qty' => 20, 'price' => 4000, 'type' => 'Food'],
                ['item_name' => 'French Fries', 'qty' => 30, 'price' => 2500, 'type' => 'Food'],
            ];
            foreach ($items as $item) {
                Inventory::create($item);
            }
        }

        if (Pricing::count() == 0) {
            $pricings = [
                ['name' => 'Member Standard', 'hour' => 1, 'price' => 2500],
                ['name' => 'Guest Standard', 'hour' => 1, 'price' => 3000],
                ['name' => 'VIP Hour', 'hour' => 1, 'price' => 5000],
            ];
            foreach ($pricings as $p) {
                Pricing::create($p);
            }
        }

        // 2. Loop through the last 90 days
        $start = Carbon::now()->subMonths(3);
        $end = Carbon::now();

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            // Random number of records per day (3 to 15)
            $recordCount = rand(3, 15);
            for ($i = 0; $i < $recordCount; $i++) {
                Record::factory()->create([
                    'created_date' => $date->copy()->setHour(rand(8, 23))->setMinute(rand(0, 59)),
                    'created_at' => $date,
                ]);
            }

            // Random number of bookings per day (1 to 5)
            $bookingCount = rand(1, 5);
            for ($i = 0; $i < $bookingCount; $i++) {
                $booking = Booking::factory()->create([
                    'date' => $date->toDateString(),
                ]);
                
                // Attach random seats to booking
                $seats = Seat::inRandomOrder()->limit(rand(1, 4))->pluck('id');
                $booking->seats()->attach($seats);
            }

            // Random outcomes (expenses) a few times a week
            if (rand(1, 10) > 8) {
                Outcome::factory()->create([
                    'created_at' => $date,
                ]);
            }
        }
    }
}
