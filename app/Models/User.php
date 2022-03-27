<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Interfaces\Customer;
use NunoMazer\Samehouse\BelongsToTenants;
use DB;
use App\Scops\TenantScope;
use Landlord;
use Lab404\Impersonate\Models\Impersonate;
class User extends Authenticatable implements MustVerifyEmail, Wallet,Customer
{ use BelongsToTenants;
  use HasApiTokens, Notifiable, HasRoles,HasWallet, CanPay,Impersonate;
    use LogsActivity;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password','work_hours'
  ];
    protected static $logFillable = true;
    protected static $logAttributes = [];
    protected static $logOnlyDirty = true;
    protected static $logName = "Admin";
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
      'work_hours' => 'array',
  ];
    public $tenantColumns = ['company_id'];
 
    public function profile()
    {
        return $this->hasOne('App\Models\Userprofile')->withDefault();;
    }
    public function parent()
    {
        return $this->hasOne('App\Models\User', 'id', 'parent_id');
    }
    public function child()
    {
        return $this->hasMany('App\Models\User', 'parent_id', 'id');
    }
    public function smsconfig()
    {
        return $this->hasOne('App\Models\SmsConfig');
    }
    public function ispusers()
    {
        return $this->hasMany('App\Models\Subscriber','owner','id');
    }
    public function devices()
    {
        return $this->morphToMany('App\Models\NAS', 'user_nasable');
    }
    public function plans()
    {
        return $this->morphToMany('App\Models\Profile', 'user_profileable');
    }
    public function Zone()
    {
        return $this->morphToMany('App\Models\Zone', 'user_zoneable');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id','id')->withoutGlobalScope('company_id');
    }
    public function issuperadmin()
    {
        return $this->hasRole('super admin');
    }
    public function revenue()
    {
        return Revenue::with('reseller','reseller.parent')->where('user_id',$this->id);
    }
    public function invoice_paid(){
        return $this->hasOne('App\Models\Invoice','paid_by','id');
    }
    public function paid_by(){
        return $this->hasone('App\Models\User','paid_id','id');
    }

    public function get_month_revenue(){
        $now = Carbon::now();
        $month=$now->month;
        // return $this->id;
        $data= Revenue::select(DB::raw('sum(revenue) as rev'), DB::raw("MONTH(created_at) as month"))->where('status',0)->where('user_id',$this->id)->whereRaw('MONTH(created_at)',$month)->groupBy(DB::raw("MONTH(created_at)") )->first();
        if($data)
            return $data->rev ;
        else return 0;
    }
    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket','assigned_to','id');
    }
    public function allocated_plan(){
        return $this->hasMany('App\Models\ResellerPlan','reseller_id','id');
    }
    public    function get_status(){
        return $this->status_id;
    }
    public function onlinestatus(){
        return $this->hasOne('App\Models\AdminStatus','id','status_id');
    }
    public function classification_groups(){
        return $this->belongsToMany(ClassificationGroup::class,"admin_groups","user_id","classification_group_id")->withPivot(["level_name"])->withoutGlobalScope('company_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name','email','password' ] ) ->useLogName('Admin') ->logOnlyDirty();;
    }
    protected static function boot(){

     //   static::$landlord = app(TenantManager::class);

        parent::boot();
//
        static::saving(function (Model $model) {
            static::$logAttributes = array_keys($model->getDirty());
        });
        if(auth()->check())
     static::addGlobalScope(new TenantScope );
    }


}
