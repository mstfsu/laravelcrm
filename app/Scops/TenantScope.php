<?php
namespace App\Scops;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Landlord;
use Auth;
use Session;
class TenantScope implements  Scope
{
public function apply(Builder $builder,Model $model){

    $session =Session::get('tenant_impersonation');
    if(isset($session)) {
        $tenant = $session;


        if ($tenant == 1) {

            $builder->withoutGlobalScope('company_id');
        }
        else{


    //     $builder->withoutGlobalScope('company_id')->where('company_id',$tenant);
        }
    }


}
}