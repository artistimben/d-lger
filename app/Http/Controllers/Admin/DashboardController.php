<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Trip;
use App\Models\Truck;
use App\Models\User;
use App\Services\FinanceService;

class DashboardController extends Controller
{
    public function __invoke(FinanceService $finance)
    {
        $companies = Company::withCount(['trucks', 'drivers', 'trips'])->latest()->get();

        $summaries = $companies->map(function (Company $company) use ($finance) {
            $month = $finance->summary($company, now()->startOfMonth(), now()->endOfMonth());

            return [
                'company' => $company,
                'net' => $month['net'],
                'income' => $month['income'],
                'trips' => $month['trip_count'],
            ];
        });

        return view('admin.dashboard', [
            'companyCount' => Company::count(),
            'truckCount' => Truck::count(),
            'tripCount' => Trip::count(),
            'userCount' => User::where('role', 'firma')->count(),
            'summaries' => $summaries,
        ]);
    }
}
