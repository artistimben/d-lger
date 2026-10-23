<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\TripExpense;
use App\Services\FinanceService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke(Request $request, FinanceService $finance)
    {
        $from = $request->date('from') ?? now()->startOfMonth();
        $to = $request->date('to') ?? now()->endOfMonth();
        $company = $request->user()->company;

        $range = $finance->summary($company, $from, $to);
        $month = $finance->summary($company, now()->startOfMonth(), now()->endOfMonth());
        $year = $finance->summary($company, now()->startOfYear(), now()->endOfYear());

        return view('company.reports.index', [
            'range' => $range,
            'month' => $month,
            'year' => $year,
            'from' => $from,
            'to' => $to,
            'categories' => TripExpense::CATEGORIES + \App\Models\ExtraExpense::CATEGORIES,
        ]);
    }
}
