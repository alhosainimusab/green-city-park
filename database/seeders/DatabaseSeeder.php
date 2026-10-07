<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RideSeeder::class,
            EventSeeder::class,
            PromotionSeeder::class,
            BookingSeeder::class,
            NotificationSeeder::class,
            RideStatusLogSeeder::class,
        ]);
    }
}
