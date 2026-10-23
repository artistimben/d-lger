<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\ExtraExpense;
use App\Models\ExtraIncome;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;

        return view('company.finance.index', [
            'incomes' => $company->extraIncomes()->latest('occurred_on')->limit(40)->get(),
            'expenses' => $company->extraExpenses()->latest('occurred_on')->limit(40)->get(),
            'categories' => ExtraExpense::CATEGORIES,
        ]);
    }

    public function storeIncome(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'amount' => ['required', 'numeric', 'min:0'],
            'occurred_on' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
        $data['company_id'] = $request->user()->company_id;
        ExtraIncome::create($data);

        return back()->with('ok', 'Ekstra gelir kaydedildi.');
    }

    public function destroyIncome(Request $request, ExtraIncome $income)
    {
        abort_unless($income->company_id === $request->user()->company_id, 403);
        $income->delete();

        return back()->with('ok', 'Gelir silindi.');
    }

    public function storeExpense(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['required', Rule::in(array_keys(ExtraExpense::CATEGORIES))],
            'amount' => ['required', 'numeric', 'min:0'],
            'occurred_on' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
        $data['company_id'] = $request->user()->company_id;
        ExtraExpense::create($data);

        return back()->with('ok', 'Ekstra gider kaydedildi.');
    }

    public function destroyExpense(Request $request, ExtraExpense $expense)
    {
        abort_unless($expense->company_id === $request->user()->company_id, 403);
        $expense->delete();

        return back()->with('ok', 'Gider silindi.');
    }
}
