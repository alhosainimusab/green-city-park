<?php

namespace Database\Seeders;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RideStatusLogSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where('role', 'staff')->first();
        $admin = User::where('role', 'admin')->first();
        $rides = Ride::all();

        if ($rides->isEmpty() || !$staff) return;

        $logs = [
            ['ride_name' => 'Sky Wheel',       'old' => 'active',      'new' => 'maintenance', 'reason' => 'Scheduled maintenance — gear inspection', 'days_ago' => 3],
            ['ride_name' => 'Sky Wheel',       'old' => 'closed',      'new' => 'active',       'reason' => 'Maintenance completed, reopened',          'days_ago' => 10],
            ['ride_name' => 'Water Madness',   'old' => 'active',      'new' => 'maintenance', 'reason' => 'Water pump replacement',                    'days_ago' => 7],
            ['ride_name' => 'Drop Tower',      'old' => 'maintenance', 'new' => 'active',       'reason' => 'Safety inspection passed',                  'days_ago' => 5],
            ['ride_name' => 'Adventure Train', 'old' => 'active',      'new' => 'maintenance', 'reason' => 'Track inspection — precautionary measure',   'days_ago' => 14],
            ['ride_name' => 'Adventure Train', 'old' => 'maintenance', 'new' => 'active',       'reason' => 'Track cleared, operational again',           'days_ago' => 11],
            ['ride_name' => 'Pirate Ship',     'old' => 'active',      'new' => 'maintenance', 'reason' => 'Hydraulic system service',                   'days_ago' => 20],
            ['ride_name' => 'Pirate Ship',     'old' => 'maintenance', 'new' => 'active',       'reason' => 'Hydraulic system repaired',                  'days_ago' => 18],
        ];

        foreach ($logs as $log) {
            $ride = $rides->firstWhere('name_en', $log['ride_name']);
            if (!$ride) $ride = $rides->first();

            $updatedBy = ($log['days_ago'] % 2 === 0) ? $staff->id : $admin->id;
            $ts = now()->subDays($log['days_ago']);

            DB::table('ride_status_logs')->insert([
                'ride_id'    => $ride->id,
                'updated_by' => $updatedBy,
                'old_status' => $log['old'],
                'new_status' => $log['new'],
                'reason'     => $log['reason'],
                'created_at' => $ts,
                'updated_at' => $ts,
            ]);
        }
    }
}
