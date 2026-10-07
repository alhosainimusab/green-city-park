<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\RideStatusLog;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::latest()->paginate(15);
        return view('admin.rides.index', compact('rides'));
    }

    public function create()
    {
        return view('admin.rides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'min_age' => 'nullable|integer|min:0',
            'min_height' => 'nullable|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,closed',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rides', 'public');
        }

        Ride::create($data);
        return redirect()->route('admin.rides.index')->with('success', __('messages.ride_created'));
    }

    public function edit(Ride $ride)
    {
        return view('admin.rides.edit', compact('ride'));
    }

    public function update(Request $request, Ride $ride)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'min_age' => 'nullable|integer|min:0',
            'min_height' => 'nullable|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,closed',
            'reason' => 'nullable|string',
        ]);

        $oldStatus = $ride->status;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rides', 'public');
        }

        $ride->update($data);

        if ($oldStatus !== $data['status']) {
            RideStatusLog::create([
                'ride_id' => $ride->id,
                'updated_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $data['status'],
                'reason' => $data['reason'] ?? null,
            ]);
        }

        return redirect()->route('admin.rides.index')->with('success', __('messages.ride_updated'));
    }

    public function destroy(Ride $ride)
    {
        $ride->delete();
        return redirect()->route('admin.rides.index')->with('success', __('messages.ride_deleted'));
    }
}
