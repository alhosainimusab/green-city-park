<?php

namespace Database\Seeders;

use App\Models\Ride;
use Illuminate\Database\Seeder;

class RideSeeder extends Seeder
{
    public function run(): void
    {
        $rides = [
            [
                'name_ar' => 'قطار المغامرة',
                'name_en' => 'Adventure Train',
                'description_ar' => 'رحلة مثيرة عبر أنفاق مظلمة ومناطق مغامرات',
                'description_en' => 'An exciting journey through dark tunnels and adventure zones',
                'category' => 'thrill',
                'min_age' => 8,
                'min_height' => 120,
                'capacity' => 24,
                'status' => 'active',
                'traffic_level' => 'high',
                'wait_time' => 25,
            ],
            [
                'name_ar' => 'دوامة الفرح',
                'name_en' => 'Joy Spin',
                'description_ar' => 'دوامة سريعة ومثيرة للعائلات',
                'description_en' => 'Fast and exciting spin ride for families',
                'category' => 'family',
                'min_age' => 5,
                'min_height' => 100,
                'capacity' => 20,
                'status' => 'active',
                'traffic_level' => 'medium',
                'wait_time' => 15,
            ],
            [
                'name_ar' => 'مجنون المياه',
                'name_en' => 'Water Madness',
                'description_ar' => 'منزلق مائي ضخم للمتعة والإثارة',
                'description_en' => 'Giant water slide for fun and excitement',
                'category' => 'water',
                'min_age' => 7,
                'min_height' => 110,
                'capacity' => 12,
                'status' => 'active',
                'traffic_level' => 'high',
                'wait_time' => 30,
            ],
            [
                'name_ar' => 'قلعة الأطفال',
                'name_en' => 'Kids Castle',
                'description_ar' => 'منطقة ألعاب ترفيهية مخصصة للأطفال الصغار',
                'description_en' => 'Entertainment playground dedicated for young children',
                'category' => 'kids',
                'min_age' => 2,
                'min_height' => null,
                'capacity' => 30,
                'status' => 'active',
                'traffic_level' => 'low',
                'wait_time' => 5,
            ],
            [
                'name_ar' => 'عجلة السماء',
                'name_en' => 'Sky Wheel',
                'description_ar' => 'عجلة فيريس عملاقة تتيح رؤية بانورامية للمدينة',
                'description_en' => 'Giant ferris wheel offering panoramic city views',
                'category' => 'family',
                'min_age' => 3,
                'min_height' => null,
                'capacity' => 40,
                'status' => 'maintenance',
                'traffic_level' => null,
                'wait_time' => null,
            ],
            [
                'name_ar' => 'سفينة القراصنة',
                'name_en' => 'Pirate Ship',
                'description_ar' => 'سفينة تتأرجح للمغامرين الجريئين',
                'description_en' => 'Swinging ship for bold adventurers',
                'category' => 'thrill',
                'min_age' => 10,
                'min_height' => 130,
                'capacity' => 36,
                'status' => 'active',
                'traffic_level' => 'medium',
                'wait_time' => 20,
            ],
            [
                'name_ar' => 'قطار الأطفال الصغير',
                'name_en' => 'Mini Train',
                'description_ar' => 'قطار صغير يدور في الحديقة مناسب للعائلات',
                'description_en' => 'Small train circling the park, suitable for families',
                'category' => 'kids',
                'min_age' => 1,
                'min_height' => null,
                'capacity' => 50,
                'status' => 'active',
                'traffic_level' => 'low',
                'wait_time' => 5,
            ],
            [
                'name_ar' => 'برج الرعب',
                'name_en' => 'Drop Tower',
                'description_ar' => 'برج سقوط حر مثير للمغامرين',
                'description_en' => 'Free fall drop tower for thrill seekers',
                'category' => 'thrill',
                'min_age' => 14,
                'min_height' => 140,
                'capacity' => 16,
                'status' => 'active',
                'traffic_level' => 'high',
                'wait_time' => 35,
            ],
        ];

        foreach ($rides as $ride) {
            Ride::create($ride);
        }
    }
}
