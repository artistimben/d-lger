<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class LocationShareController extends Controller
{
    public function show(string $token)
    {
        $truck = Truck::where('share_token', $token)->firstOrFail();

        return view('location.share', compact('truck'));
    }

    public function store(Request $request, string $token)
    {
        $truck = Truck::where('share_token', $token)->firstOrFail();

        $data = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'city' => ['nullable', 'string', 'max:80'],
        ]);

        $truck->locationPings()->create($data);
        $truck->update([
            'last_lat' => $data['lat'],
            'last_lng' => $data['lng'],
            'last_city' => $data['city'] ?? $truck->last_city,
            'last_located_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
