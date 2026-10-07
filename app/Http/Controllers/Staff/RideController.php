<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\RideStatusLog;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::latest()->paginate(15);
        return view('staff.rides.index', compact('rides'));
    }

    public function updateStatus(Request $request, Ride $ride)
    {
        $data = $request->validate([
            'status'        => 'required|in:active,maintenance,closed',
            'reason'        => 'nullable|string|max:500',
            'traffic_level' => 'nullable|in:low,medium,high',
            'wait_time'     => 'nullable|integer|min:0|max:999',
        ]);

        $oldStatus = $ride->status;

        $ride->update([
            'status'        => $data['status'],
            'traffic_level' => $data['status'] === 'active' ? ($data['traffic_level'] ?? null) : null,
            'wait_time'     => $data['status'] === 'active' ? ($data['wait_time'] ?? null) : null,
        ]);

        RideStatusLog::create([
            'ride_id' => $ride->id,
            'updated_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $data['status'],
            'reason' => $data['reason'] ?? null,
        ]);

        return back()->with('success', __('messages.ride_status_updated'));
    }
}
