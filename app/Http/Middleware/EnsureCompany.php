<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user?->isCompany() || ! $user->company_id || ! $user->is_active) {
            abort(403, 'Bu sayfa yalnızca aktif firma hesapları içindir.');
        }

        if ($user->company && ! $user->company->is_active) {
            abort(403, 'Firma hesabı pasif durumda.');
        }

        return $next($request);
    }
}
