<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            [
                'code' => 'WELCOME20',
                'name_ar' => 'عرض الترحيب',
                'name_en' => 'Welcome Offer',
                'description_ar' => 'خصم 20% للزوار الجدد',
                'description_en' => '20% discount for new visitors',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(3)->toDateString(),
                'max_uses' => 100,
                'used_count' => 23,
                'is_active' => true,
            ],
            [
                'code' => 'FAMILY500',
                'name_ar' => 'خصم العائلة',
                'name_en' => 'Family Discount',
                'description_ar' => 'خصم 500 ريال للحجوزات العائلية',
                'description_en' => '500 YER discount for family bookings',
                'discount_type' => 'fixed',
                'discount_value' => 500,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonths(2)->toDateString(),
                'max_uses' => 50,
                'used_count' => 8,
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER30',
                'name_ar' => 'عرض الصيف',
                'name_en' => 'Summer Special',
                'description_ar' => 'خصم 30% في موسم الصيف',
                'description_en' => '30% off during summer season',
                'discount_type' => 'percentage',
                'discount_value' => 30,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addMonth()->toDateString(),
                'max_uses' => 200,
                'used_count' => 12,
                'is_active' => true,
            ],
            [
                'code' => 'EID2026',
                'name_ar' => 'عرض العيد 2026',
                'name_en' => 'Eid 2026 Celebration',
                'description_ar' => 'خصم 25% احتفالاً بعيد الأضحى المبارك',
                'description_en' => '25% off to celebrate Eid Al-Adha 2026',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addDays(14)->toDateString(),
                'max_uses' => 150,
                'used_count' => 7,
                'is_active' => true,
            ],
            [
                'code' => 'WEEKEND',
                'name_ar' => 'عرض نهاية الأسبوع',
                'name_en' => 'Weekend Deal',
                'description_ar' => 'خصم 1000 ريال على حجوزات نهاية الأسبوع',
                'description_en' => '1000 YER off on weekend bookings',
                'discount_type' => 'fixed',
                'discount_value' => 1000,
                'valid_from' => now()->toDateString(),
                'valid_until' => now()->addDays(30)->toDateString(),
                'max_uses' => 80,
                'used_count' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::create($promo);
        }
    }
}
