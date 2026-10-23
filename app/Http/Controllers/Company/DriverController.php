<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $drivers = $request->user()->company->drivers()->withCount('trips')->latest()->get();

        return view('company.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('company.drivers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['company_id'] = $request->user()->company_id;
        $data['is_active'] = $request->boolean('is_active', true);
        Driver::create($data);

        return redirect()->route('firma.drivers.index')->with('ok', 'Şoför eklendi.');
    }

    public function edit(Request $request, Driver $driver)
    {
        abort_unless($driver->company_id === $request->user()->company_id, 403);

        return view('company.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        abort_unless($driver->company_id === $request->user()->company_id, 403);
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $driver->update($data);

        return redirect()->route('firma.drivers.index')->with('ok', 'Şoför güncellendi.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'license_no' => ['nullable', 'string', 'max:40'],
            'license_expires_at' => ['nullable', 'date'],
            'default_wage' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}
