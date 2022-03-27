<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
class Checkzone
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $session = Session::get('tenant_impersonation');
            if (isset($session))
                $tenant = $session;
            else
                $tenant = $request->user()->company_id;

            if($tenant==1)
            return $next($request);
            else
                return redirect("/");
        }
    }
}
