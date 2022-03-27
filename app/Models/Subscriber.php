<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanPay;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use NunoMazer\Samehouse\BelongsToTenants;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Scops\TenantScope;
use Landlord;
use Hash;
use Log;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Subscriber extends   Authenticatable implements  Customer
{  use BelongsToTenants;
    use LogsActivity;
    use   CanPay;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $guard = 'customers';
    protected $table = 'isp_users';
     protected static $logFillable = true;
    protected static $logAttributes = [];

    protected static $logName = "Subscriber";
    public $timestamps = false;
    protected static $logOnlyDirty = true;
    protected $dates=['expiration','created_at','acctstarttime','blocked_at'];
    protected  $fillable=['firstname','lastname','username','password','email','phone','mobile','fullname','pincode','onlinestatus','state','city','address','latitude','longitude','status','srvid','user_type','created_by','created_at','updated_at'];
    /*public function profile()
    {
        return $this->belongsTo('App\Model\Profile', 'owner');
    }*/

    public $tenantColumns = ['company_id'];
    public function getAuthPassword()
    { log::info("password");
        return Hash::make($this->portal_pass);;
    }
    public function owners()
    {
        return $this->hasOne('App\Models\User', 'id', 'owner');
    }
    public function comments()
    {
        return $this->morphToMany('App\Models\Comment', 'lead_commentable');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
    public function nas()
    {
        return $this->belongsTo('App\Models\NAS', 'nasipaddress', 'shortname')->withoutGlobalScope('company_id');
    }
    public function radAcctData() {
        return $this->hasOne('App\Models\Radacct', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function radAcctall() {
        return $this->hasMany('App\Models\Radacct', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function radcheckdata() {
        return $this->hasMany('App\Models\Radcheck', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function radreplydata() {
        return $this->hasMany('App\Models\RadReply', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function radusergroupdata() {
        return $this->hasMany('App\Models\RadUserGroup', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function usermac() {
        return $this->hasOne('App\Models\UserMAC', 'username', 'username')->withoutGlobalScope('company_id');
    }

    public function onlineuser() {
        return $this->hasMany('App\Models\Radacct', 'username', 'username')->whereNull('acctstoptime')->withoutGlobalScope('company_id');
    }
    public function profiles()
    {
        return $this->hasOne('App\Models\Profile', 'id', 'srvid')->withoutGlobalScope('company_id')->withoutGlobalScope('company_id');
    }
    public   function Usersstatus()
    {
        return $this->hasOne('App\Models\Radacct', 'username', 'username')->withoutGlobalScope('company_id');
    }
    public function isonline(){
        return $this->hasone('App\Models\Radacct', 'username', 'username')->whereNull('acctstoptime')->latest()-> withoutGlobalScope('company_id');
    }

    public function iscusomeronline(){
        return $this->hasMany('App\Models\CustomerOnline','customer_id','id')->withoutGlobalScope('company_id');
    }
    public function Userstatus()
    {
        return $this->hasOne('App\Models\ISPStatus', 'name', 'status')->withoutGlobalScope('company_id');

    }
    public function invoices(){
        $today=Carbon::now()->format('Y-m-d');
        return $this->hasMany('App\Models\Invoice','customer_id','id')->withoutGlobalScope('company_id');
    }
    public function unpaidinvoices(){
        $today=Carbon::now()->format('Y-m-d');
        return $this->hasMany('App\Models\Invoice','customer_id','id')->withoutGlobalScope('company_id')->where('status',"!=",'paid');
    }
    public function renews(){
        return $this->hasOne('\App\Models\RenewCustomer','customer_id','id')->latest()->withoutGlobalScope('company_id');
    }
    public function getusage(){
        $usage=Radacct::select( DB::raw('SUM(AcctInputOctets) as Download'),DB::raw('SUM(AcctOutputOctets) as Upload')   )->whereDate('renew_code', '>=',$this->renew_code)  ->withoutGlobalScope('company_id')->first();
        $total=(int)$usage->Download + (int)$usage->upload;
        return $total;
    }
    function  onlinecount(){
        return Subscriber::groupBy([ 'online'])->select( 'online', DB::raw('count(*) as total'))->withoutGlobalScope('company_id')->get();
    }
    public function grace(){
        return $this->hasMany('App\Models\Grace','customer_id','id');
    }
    public static function get_online_user_data($username,$key){
        $data=Radacct::withoutGlobalScope('company_id')->whereNull('acctstoptime')->where('username',$username)->get()->last();
        log::info($data);
        if($data)
        return $data->$key;
        else
            return "";
}
    public static function get_nas_user_data($user,$key){

                  log::info('ussss'.$user);
                $router = NAS::withoutGlobalScope('company_id')->where('shortname', $user->nasipaddress)->first();

                if($router) {

                    return $router->$key;
                }

        }


public static function getonlinecount(){
        $user_id=auth()->user()->id;

    if(auth()->user()->hasAnyRole(['super admin','administrator','manager'])) {
        $count = Subscriber::query()->where('onlinestatus', 'online')->count();
    }
    else{
        $count = Subscriber::query()->where('onlinestatus', 'online')->whereHas('owners', function ($q) use ($user_id) {
            return $q->where('users.id', '=', $user_id);
        })->count();
    }
    return $count;
}
    public static function getactivecount(){
        $user_id=auth()->user()->id;

        if(auth()->user()->hasAnyRole(['super admin','administrator','manager'])) {
            $count = Subscriber::query()->where('status', 'active')->count();
        }
        else{
            $count = Subscriber::query()->where('status', 'active')->whereHas('owners', function ($q) use ($user_id) {
                return $q->where('users.id', '=', $user_id);
            })->count();
        }
        return $count;
    }
    public function group(){
        return $this->belongsTo('App\Models\Ispgroup','id','customer_id');
    }
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['username','password','phone','mobile','address','city','state','mac','expiration','staticipcm','staticipcpe','email','nationalid','status','fullname','addressbill','countrybill','pincode','countrybill','citybill','street','longitude','latitude','address_bill'] ) ->useLogName('Customer') ->logOnlyDirty();;
    }

    public static function boot() {
        parent::boot();
        static::saving(function (Model $model) {
            static::$logAttributes = array_keys($model->getDirty());
        });
        static::deleting(function($user) { // before delete() method call this

            $user->radAcctall()->delete();



            // do the rest of the cleanup...
        });


     static::addGlobalScope(new TenantScope );

    }
    public function tickets() {
        return $this->hasMany('App\Models\Ticket', 'customer_id', 'id');
    }


}
