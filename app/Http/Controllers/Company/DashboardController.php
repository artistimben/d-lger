<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, FinanceService $finance)
    {
        $company = $request->user()->company()->with(['trucks', 'drivers'])->firstOrFail();
        $month = $finance->summary($company, now()->startOfMonth(), now()->endOfMonth());
        $year = $finance->summary($company, now()->startOfYear(), now()->endOfYear());

        $activeTrips = $company->trips()->with(['truck', 'driver'])->where('status', 'yolda')->latest('started_at')->get();
        $recentTrips = $company->trips()->with(['truck', 'driver'])->latest('started_at')->limit(6)->get();

        return view('company.dashboard', [
            'company' => $company,
            'month' => $month,
            'year' => $year,
            'activeTrips' => $activeTrips,
            'recentTrips' => $recentTrips,
            'inspectionAlerts' => $company->trucks->filter->isInspectionDueSoon(),
        ]);
    }
}
