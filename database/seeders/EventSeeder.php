<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title_ar' => 'مهرجان الصيف الكبير',
                'title_en' => 'Grand Summer Festival',
                'description_ar' => 'احتفل معنا بأكبر مهرجان صيفي في المدينة مع عروض متنوعة وأنشطة للجميع',
                'description_en' => 'Celebrate with us at the city\'s biggest summer festival with diverse shows and activities for all',
                'event_date' => now()->addDays(15)->toDateString(),
                'start_time' => '10:00',
                'end_time' => '22:00',
                'location_ar' => 'المسرح الرئيسي - مدينة غرين سيتي',
                'location_en' => 'Main Stage - Green City Park',
                'is_active' => true,
            ],
            [
                'title_ar' => 'ليلة العروض الموسيقية',
                'title_en' => 'Musical Night',
                'description_ar' => 'استمتع بأجمل الأغاني والألحان مع نخبة من الفنانين اليمنيين',
                'description_en' => 'Enjoy the most beautiful songs and melodies with elite Yemeni artists',
                'event_date' => now()->addDays(25)->toDateString(),
                'start_time' => '19:00',
                'end_time' => '23:00',
                'location_ar' => 'ساحة الفعاليات',
                'location_en' => 'Events Square',
                'is_active' => true,
            ],
            [
                'title_ar' => 'يوم الطفل السعيد',
                'title_en' => 'Happy Children\'s Day',
                'description_ar' => 'يوم مميز مخصص للأطفال مع ألعاب وهدايا ومسابقات ممتعة',
                'description_en' => 'Special day for children with games, gifts and fun competitions',
                'event_date' => now()->addDays(7)->toDateString(),
                'start_time' => '09:00',
                'end_time' => '17:00',
                'location_ar' => 'منطقة الأطفال',
                'location_en' => 'Children\'s Area',
                'is_active' => true,
            ],
            [
                'title_ar' => 'مسابقة الرسم والفنون',
                'title_en' => 'Art & Drawing Competition',
                'description_ar' => 'شارك في مسابقة الرسم والفنون وأظهر موهبتك للجميع',
                'description_en' => 'Participate in the art and drawing competition and show your talent',
                'event_date' => now()->addDays(35)->toDateString(),
                'start_time' => '10:00',
                'end_time' => '14:00',
                'location_ar' => 'قاعة الفنون',
                'location_en' => 'Arts Hall',
                'is_active' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
