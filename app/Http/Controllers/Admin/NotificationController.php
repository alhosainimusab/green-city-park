<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::with('user')->latest()->paginate(20);
        $visitors = User::where('role', 'visitor')->orderBy('name')->get();
        return view('admin.notifications.index', compact('notifications', 'visitors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en'  => 'required|string|max:200',
            'title_ar'  => 'required|string|max:200',
            'body_en'   => 'required|string|max:1000',
            'body_ar'   => 'required|string|max:1000',
            'type'      => 'required|in:info,success,danger',
            'target'    => 'required|in:all,user',
            'user_id'   => 'required_if:target,user|nullable|exists:users,id',
        ]);

        if ($data['target'] === 'all') {
            $users = User::where('role', 'visitor')->pluck('id');
            foreach ($users as $uid) {
                AppNotification::create([
                    'user_id'  => $uid,
                    'title_en' => $data['title_en'],
                    'title_ar' => $data['title_ar'],
                    'body_en'  => $data['body_en'],
                    'body_ar'  => $data['body_ar'],
                    'type'     => $data['type'],
                    'is_read'  => false,
                ]);
            }
            $msg = app()->getLocale() === 'ar'
                ? 'تم إرسال الإشعار لجميع الزوار (' . $users->count() . ')'
                : 'Notification sent to all visitors (' . $users->count() . ')';
        } else {
            AppNotification::create([
                'user_id'  => $data['user_id'],
                'title_en' => $data['title_en'],
                'title_ar' => $data['title_ar'],
                'body_en'  => $data['body_en'],
                'body_ar'  => $data['body_ar'],
                'type'     => $data['type'],
                'is_read'  => false,
            ]);
            $msg = app()->getLocale() === 'ar' ? 'تم إرسال الإشعار بنجاح' : 'Notification sent successfully';
        }

        return back()->with('success', $msg);
    }

    public function destroy(AppNotification $notification)
    {
        $notification->delete();
        return back()->with('success', app()->getLocale() === 'ar' ? 'تم حذف الإشعار' : 'Notification deleted');
    }
}
