<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Example 1: If using explicit prefixes:
        // you can parse the path segment directly.
        $path = $request->path(); // e.g., 'ehr/dashboard', 'mir/patients', etc.

        if (str_starts_with($path, 'ehr')) {
            config(['database.default' => 'ehr']);
        } elseif (str_starts_with($path, 'mir')) {
            config(['database.default' => 'mir']);
        }

        // Example 2: If using a {tenant} route param
        // $tenant = $request->route('tenant'); // 'ehr' or 'mir'
        // if ($tenant === 'ehr') {
        //     config(['database.default' => 'ehr']);
        // } elseif ($tenant === 'mir') {
        //     config(['database.default' => 'mir']);
        // }

        return $next($request);
    }
}
