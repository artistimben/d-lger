<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['users'])->withCount(['trucks', 'trips', 'drivers'])->latest()->get();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'tax_number' => ['nullable', 'string', 'max:40'],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $company = Company::create([
            'name' => $data['name'],
            'tax_number' => $data['tax_number'] ?? null,
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => true,
        ]);

        User::create([
            'name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'firma',
            'company_id' => $company->id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.companies.index')->with('ok', 'Firma hesabı oluşturuldu.');
    }

    public function show(Company $company)
    {
        $company->load(['users', 'trucks', 'drivers']);

        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $company->load('users');

        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $owner = $company->users()->first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'tax_number' => ['nullable', 'string', 'max:40'],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'user_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($owner?->id)],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $company->update([
            'name' => $data['name'],
            'tax_number' => $data['tax_number'] ?? null,
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($owner) {
            $owner->name = $data['user_name'];
            $owner->email = $data['email'];
            $owner->is_active = $company->is_active;
            if (! empty($data['password'])) {
                $owner->password = Hash::make($data['password']);
            }
            $owner->save();
        }

        return redirect()->route('admin.companies.show', $company)->with('ok', 'Firma güncellendi.');
    }
}
