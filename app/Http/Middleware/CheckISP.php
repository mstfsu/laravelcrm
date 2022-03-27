<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\Company;
class CheckISP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {  if (auth()->check()) {
        $session = Session::get('tenant_impersonation');
        if (isset($session))
            $tenant = $session;
        else
            $tenant = $request->user()->company_id;

                $company=Company::withoutGlobalScope('company_id')->where('id',$tenant)->first();
        if($tenant==1 || ($company->company_id==1 && $company->create_subzone==1))
            return $next($request);
        else
            return redirect("/");
    }
       
    }
}
