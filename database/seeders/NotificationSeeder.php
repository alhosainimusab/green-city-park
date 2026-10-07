<?php

namespace Database\Seeders;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = User::where('role', 'visitor')->get();

        $systemNotifs = [
            [
                'title_ar' => 'مرحباً بك في جرين سيتي!',
                'title_en' => 'Welcome to Green City!',
                'body_ar'  => 'شكراً لتسجيلك. نتطلع إلى استقبالك في حديقتنا الترفيهية قريباً.',
                'body_en'  => 'Thank you for registering. We look forward to welcoming you to our park soon.',
                'type'     => 'info',
            ],
            [
                'title_ar' => 'عرض العيد الخاص 25%',
                'title_en' => 'Eid Special Offer 25% Off',
                'body_ar'  => 'استخدم كود EID2026 للحصول على خصم 25% على جميع التذاكر حتى نهاية الشهر.',
                'body_en'  => 'Use code EID2026 for 25% off all tickets until end of month.',
                'type'     => 'info',
            ],
            [
                'title_ar' => 'تأكيد حجزك',
                'title_en' => 'Your Booking is Confirmed',
                'body_ar'  => 'تم تأكيد حجزك بنجاح. يمكنك الآن تحميل تذكرتك بكود QR من قسم التذاكر.',
                'body_en'  => 'Your booking has been confirmed. You can now download your QR ticket from the Tickets section.',
                'type'     => 'success',
            ],
            [
                'title_ar' => 'تذكير بموعد زيارتك',
                'title_en' => 'Upcoming Visit Reminder',
                'body_ar'  => 'تذكير: زيارتك لحديقة جرين سيتي غداً. احضر تذكرة QR الخاصة بك.',
                'body_en'  => 'Reminder: Your visit to Green City Park is tomorrow. Bring your QR ticket.',
                'type'     => 'info',
            ],
        ];

        foreach ($visitors as $visitor) {
            // Welcome notification for all visitors
            AppNotification::create([
                'user_id'  => $visitor->id,
                'title_ar' => $systemNotifs[0]['title_ar'],
                'title_en' => $systemNotifs[0]['title_en'],
                'body_ar'  => $systemNotifs[0]['body_ar'],
                'body_en'  => $systemNotifs[0]['body_en'],
                'type'     => $systemNotifs[0]['type'],
                'is_read'  => false,
                'created_at' => now()->subDays(rand(5, 30)),
            ]);

            // Promo notification
            AppNotification::create([
                'user_id'  => $visitor->id,
                'title_ar' => $systemNotifs[1]['title_ar'],
                'title_en' => $systemNotifs[1]['title_en'],
                'body_ar'  => $systemNotifs[1]['body_ar'],
                'body_en'  => $systemNotifs[1]['body_en'],
                'type'     => $systemNotifs[1]['type'],
                'is_read'  => rand(0, 1) === 1,
                'created_at' => now()->subDays(rand(1, 5)),
            ]);
        }

        // Booking confirmation for first 3 visitors
        foreach ($visitors->take(3) as $visitor) {
            AppNotification::create([
                'user_id'  => $visitor->id,
                'title_ar' => $systemNotifs[2]['title_ar'],
                'title_en' => $systemNotifs[2]['title_en'],
                'body_ar'  => $systemNotifs[2]['body_ar'],
                'body_en'  => $systemNotifs[2]['body_en'],
                'type'     => $systemNotifs[2]['type'],
                'is_read'  => false,
                'created_at' => now()->subDays(rand(1, 3)),
            ]);

            AppNotification::create([
                'user_id'  => $visitor->id,
                'title_ar' => $systemNotifs[3]['title_ar'],
                'title_en' => $systemNotifs[3]['title_en'],
                'body_ar'  => $systemNotifs[3]['body_ar'],
                'body_en'  => $systemNotifs[3]['body_en'],
                'type'     => $systemNotifs[3]['type'],
                'is_read'  => false,
                'created_at' => now()->subHours(rand(2, 24)),
            ]);
        }
    }
}
