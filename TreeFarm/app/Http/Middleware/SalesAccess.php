<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class SalesAccess
{

    /***************************************************

    handle(Request $request, Closure $next)

    This function determines how to handle an invalid request

    ****************************************************/
    public function handle(Request $request, Closure $next): Response
    {
        // If the gate doesn't allow 'sales-access'
        if (! Gate::allows('sales-access'))
        {
            // Redirect the user to the landing page
            return redirect()->route('landing');
        }

        return $next($request);
    }
}
