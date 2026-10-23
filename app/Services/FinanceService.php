<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Trip;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class FinanceService
{
    public function summary(Company $company, CarbonInterface $from, CarbonInterface $to): array
    {
        $trips = $company->trips()
            ->with('expenses')
            ->whereBetween('started_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->get();

        $freight = (float) $trips->sum('freight_fee');
        $tripExpenses = (float) $trips->sum(fn (Trip $trip) => $trip->expenses->sum('amount'));

        $extraIncome = (float) $company->extraIncomes()
            ->whereBetween('occurred_on', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $extraExpense = (float) $company->extraExpenses()
            ->whereBetween('occurred_on', [$from->toDateString(), $to->toDateString()])
            ->sum('amount');

        $income = $freight + $extraIncome;
        $expense = $tripExpenses + $extraExpense;

        $bestTrip = $trips
            ->sortByDesc(fn (Trip $trip) => (float) $trip->freight_fee - (float) $trip->expenses->sum('amount'))
            ->first();

        $expenseByCategory = $this->expenseBreakdown($trips, $company, $from, $to);

        return [
            'from' => $from,
            'to' => $to,
            'trip_count' => $trips->count(),
            'freight' => $freight,
            'trip_expenses' => $tripExpenses,
            'extra_income' => $extraIncome,
            'extra_expense' => $extraExpense,
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
            'best_trip' => $bestTrip,
            'best_trip_net' => $bestTrip
                ? (float) $bestTrip->freight_fee - (float) $bestTrip->expenses->sum('amount')
                : 0,
            'trips' => $trips,
            'expense_by_category' => $expenseByCategory,
        ];
    }

    public function expenseBreakdown(Collection $trips, Company $company, CarbonInterface $from, CarbonInterface $to): array
    {
        $map = [];

        foreach ($trips as $trip) {
            foreach ($trip->expenses as $expense) {
                $key = $expense->category;
                $map[$key] = ($map[$key] ?? 0) + (float) $expense->amount;
            }
        }

        $extras = $company->extraExpenses()
            ->whereBetween('occurred_on', [$from->toDateString(), $to->toDateString()])
            ->get();

        foreach ($extras as $expense) {
            $key = $expense->category;
            $map[$key] = ($map[$key] ?? 0) + (float) $expense->amount;
        }

        arsort($map);

        return $map;
    }
}
