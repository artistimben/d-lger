<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TruckController extends Controller
{
    public function index(Request $request)
    {
        $trucks = $request->user()->company->trucks()->withCount('trips')->latest()->get();

        return view('company.trucks.index', compact('trucks'));
    }

    public function create()
    {
        return view('company.trucks.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['company_id'] = $request->user()->company_id;
        Truck::create($data);

        return redirect()->route('firma.trucks.index')->with('ok', 'Tır kaydı eklendi.');
    }

    public function show(Request $request, Truck $truck)
    {
        $this->authorizeTruck($request, $truck);
        $truck->load(['trips.driver', 'locationPings' => fn ($q) => $q->latest()->limit(20)]);

        return view('company.trucks.show', compact('truck'));
    }

    public function edit(Request $request, Truck $truck)
    {
        $this->authorizeTruck($request, $truck);

        return view('company.trucks.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $this->authorizeTruck($request, $truck);
        $truck->update($this->validated($request, $truck->id));

        return redirect()->route('firma.trucks.show', $truck)->with('ok', 'Tır bilgileri güncellendi.');
    }

    public function destroy(Request $request, Truck $truck)
    {
        $this->authorizeTruck($request, $truck);
        $truck->delete();

        return redirect()->route('firma.trucks.index')->with('ok', 'Tır kaydı silindi.');
    }

    public function ping(Request $request, Truck $truck)
    {
        $this->authorizeTruck($request, $truck);

        $data = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'city' => ['nullable', 'string', 'max:80'],
            'note' => ['nullable', 'string', 'max:160'],
        ]);

        $truck->locationPings()->create($data);
        $truck->update([
            'last_lat' => $data['lat'],
            'last_lng' => $data['lng'],
            'last_city' => $data['city'] ?? $truck->last_city,
            'last_located_at' => now(),
        ]);

        return back()->with('ok', 'Konum güncellendi.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'plate' => [
                'required', 'string', 'max:20',
                Rule::unique('trucks', 'plate')->where('company_id', $request->user()->company_id)->ignore($ignoreId),
            ],
            'brand' => ['nullable', 'string', 'max:80'],
            'model' => ['nullable', 'string', 'max:80'],
            'year' => ['nullable', 'integer', 'min:1980', 'max:2100'],
            'capacity_kg' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['aktif', 'bakim', 'pasif'])],
            'inspection_due_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function authorizeTruck(Request $request, Truck $truck): void
    {
        abort_unless($truck->company_id === $request->user()->company_id, 403);
    }
}
