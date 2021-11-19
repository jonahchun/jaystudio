<?php
namespace App\Services\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ServiceAvailability
{

    public function handle($request, Closure $next, $state = '')
    {
        if(Auth::user() && optional($request->service)->customer_id !== Auth::user()->id) {
            return abort(404);
        }
        return $next($request);
    }
}
