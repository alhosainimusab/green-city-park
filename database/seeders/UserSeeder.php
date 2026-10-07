<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (Arabic)
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@greencitypark.ye',
            'phone' => '+967700000001',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'language' => 'ar',
        ]);

        // Admin (English)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '+967700000004',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'language' => 'en',
        ]);

        // Staff
        User::create([
            'name' => 'موظف الاستقبال',
            'email' => 'staff@greencitypark.ye',
            'phone' => '+967700000002',
            'password' => Hash::make('Staff@1234'),
            'role' => 'staff',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'محمد العمري',
            'email' => 'staff2@greencitypark.ye',
            'phone' => '+967711200002',
            'password' => Hash::make('Staff@1234'),
            'role' => 'staff',
            'language' => 'ar',
        ]);

        // Visitors
        User::create([
            'name' => 'أحمد محمد',
            'email' => 'visitor@greencitypark.ye',
            'phone' => '+967700000003',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'سارة حسن',
            'email' => 'sara@example.com',
            'phone' => '+967711100001',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'عمر سالم',
            'email' => 'omar@example.com',
            'phone' => '+967711100002',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'فاطمة العامري',
            'email' => 'fatima@example.com',
            'phone' => '+967711100003',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'خالد الشمري',
            'email' => 'khalid@example.com',
            'phone' => '+967711100004',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'نورا الزهراني',
            'email' => 'nora@example.com',
            'phone' => '+967711100005',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'ar',
        ]);

        User::create([
            'name' => 'Ahmed Al-Shibami',
            'email' => 'ahmed.en@example.com',
            'phone' => '+967711100006',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'en',
        ]);

        User::create([
            'name' => 'Layla Mohammed',
            'email' => 'layla@example.com',
            'phone' => '+967711100007',
            'password' => Hash::make('Visitor@1234'),
            'role' => 'visitor',
            'language' => 'en',
        ]);
    }
}
