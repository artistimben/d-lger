<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function __invoke(Request $request)
    {
        $trucks = $request->user()->company->trucks()
            ->with(['trips' => fn ($q) => $q->where('status', 'yolda')->latest('started_at')])
            ->get();

        return view('company.map.index', compact('trucks'));
    }
}
