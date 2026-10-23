<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripExpense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = $request->user()->company->trips()
            ->with(['truck', 'driver', 'expenses'])
            ->latest('started_at')
            ->paginate(20);

        return view('company.trips.index', compact('trips'));
    }

    public function create(Request $request)
    {
        $company = $request->user()->company;

        return view('company.trips.create', [
            'trucks' => $company->trucks()->where('status', '!=', 'pasif')->orderBy('plate')->get(),
            'drivers' => $company->drivers()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->assertOwned($request, (int) $data['truck_id'], $data['driver_id'] ?? null);

        $data['company_id'] = $request->user()->company_id;
        $data['status'] = $data['status'] ?? 'yolda';
        $trip = Trip::create($data);

        if ($request->filled('commission_amount')) {
            $trip->expenses()->create([
                'category' => 'komisyon',
                'title' => $trip->routeLabel().' komisyon',
                'amount' => $request->input('commission_amount'),
                'occurred_at' => $trip->started_at,
            ]);
        }

        if ($request->filled('driver_wage')) {
            $trip->expenses()->create([
                'category' => 'sofor',
                'title' => 'Şoför ücreti',
                'amount' => $request->input('driver_wage'),
                'occurred_at' => $trip->started_at,
            ]);
        }

        return redirect()->route('firma.trips.show', $trip)->with('ok', 'Sefer başlatıldı.');
    }

    public function show(Request $request, Trip $trip)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);
        $trip->load(['truck', 'driver', 'expenses']);

        return view('company.trips.show', [
            'trip' => $trip,
            'categories' => TripExpense::CATEGORIES,
        ]);
    }

    public function edit(Request $request, Trip $trip)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);
        $company = $request->user()->company;

        return view('company.trips.edit', [
            'trip' => $trip,
            'trucks' => $company->trucks()->orderBy('plate')->get(),
            'drivers' => $company->drivers()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Trip $trip)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);
        $data = $this->validated($request);
        $this->assertOwned($request, (int) $data['truck_id'], $data['driver_id'] ?? null);

        if (($data['status'] ?? $trip->status) === 'tamamlandi' && empty($data['completed_at'])) {
            $data['completed_at'] = now();
        }

        $trip->update($data);

        return redirect()->route('firma.trips.show', $trip)->with('ok', 'Sefer güncellendi.');
    }

    public function complete(Request $request, Trip $trip)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);
        $trip->update([
            'status' => 'tamamlandi',
            'completed_at' => now(),
        ]);

        return back()->with('ok', 'Sefer tamamlandı. Bittikten sonra da masraf ekleyebilirsiniz.');
    }

    public function storeExpense(Request $request, Trip $trip)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);

        $data = $request->validate([
            'category' => ['required', Rule::in(array_keys(TripExpense::CATEGORIES))],
            'title' => ['required', 'string', 'max:160'],
            'amount' => ['required', 'numeric', 'min:0'],
            'occurred_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $trip->expenses()->create($data);

        return back()->with('ok', 'Sefer masrafı eklendi.');
    }

    public function destroyExpense(Request $request, Trip $trip, TripExpense $expense)
    {
        abort_unless($trip->company_id === $request->user()->company_id, 403);
        abort_unless($expense->trip_id === $trip->id, 404);
        $expense->delete();

        return back()->with('ok', 'Masraf silindi.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'truck_id' => ['required', 'exists:trucks,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'origin' => ['required', 'string', 'max:80'],
            'destination' => ['required', 'string', 'max:80'],
            'customer' => ['nullable', 'string', 'max:120'],
            'cargo' => ['nullable', 'string', 'max:160'],
            'freight_fee' => ['required', 'numeric', 'min:0'],
            'distance_km' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', Rule::in(['planlandi', 'yolda', 'tamamlandi'])],
            'started_at' => ['required', 'date'],
            'completed_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function assertOwned(Request $request, int $truckId, ?string $driverId): void
    {
        abort_unless(
            $request->user()->company->trucks()->whereKey($truckId)->exists(),
            403
        );

        if ($driverId) {
            abort_unless(
                $request->user()->company->drivers()->whereKey($driverId)->exists(),
                403
            );
        }
    }
}
