<?php

namespace App\Models;

use anlutro\LaravelSettings\ArrayUtil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Auth;
use  Log;
use NunoMazer\Samehouse\BelongsToTenants;
use DB;
use App\Scops\TenantScope;
use Landlord;
use Session;
class Settings extends Model
{use BelongsToTenants;
    use HasFactory;
    protected  $table='settings';
    protected $fillable=['zone_id','name','module','val'];
    protected $dates = [
        'deleted_at',
        'published_at',
        'moderated_at',
        'updated_at'
    ];

    protected $casts = [
        'deleted_at' =>   'datetime:d-m-Y H:m:s',
        'published_at' => 'datetime:d-m-Y H:m:s',
        'moderated_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];
    public $tenantColumns = ['company_id'];
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    /**
     * Add a settings value.
     *
     * @param $key
     * @param $val
     * @param string $type
     *
     * @return bool
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
    public static function add($key, $val, $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }
        echo $key. $val;

        //   return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a settings value.
     *
     * @param $key
     * @param null $default
     *
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        $session = Session::get('tenant_impersonation');
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        else
            $tenant=1;

        $company = Company::withoutGlobalScope('company_id')->where('id', $tenant)->first();

        if(Auth::guard('customers')->check())
        {
            $tenant=Auth::guard('customers')->user()->company_id;
            if($tenant==null)
                $tenant=1;
            $company = Company::withoutGlobalScope('company_id')->where('id', $tenant)->first();

        }
        if ($company) {

            if (self::has($key)) {
              $setting = self::where('name', $key)->withoutGlobalScope('company_id')->where('company_id',$tenant)->first();


                return self::castValue($setting->val, $setting->type);
            }
            else{
                $root=$company->getRoot();
                $setting = self::where('name', $key)->withoutGlobalScope('company_id')->where('company_id',$root)->first();
                if($setting)
                 return self::castValue($setting->val, $setting->type);
                else

                    return self::getDefaultValue($key, $default);
            }

        }
        return self::getDefaultValue($key, $default);
    }



    public static function getauth($key, $company_id=1,$default = null)
    {
        if (self::hasauth($key,$company_id)) {


if($company_id==1)
     $setting = self::withoutGlobalScope('company_id')->where('name', $key)->first();
else
    $setting = self::withoutGlobalScope('company_id')->where('company_id',$company_id)->where('name', $key)->first();
if($setting)
   return self::castValue($setting->val, $setting->type);
else
    return self::getDefaultValue($key, $default);
        }

        return self::getDefaultValue($key, $default);
    }

    /**
     * Set a value for setting.
     *
     * @param $key
     * @param $val
     * @param string $type
     *
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'val'  => $val,
                'type' => $type, ]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting.
     *
     * @param $key
     *
     * @return bool
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists.
     *
     * @param $key
     *
     * @return bool
     */
    public static function has($key)
    {

        return (bool) self::getAllSettings()->where('name', $key)->count();
    }
    public static function hasauth($key,$company_id)
    {
        return (bool) self::getAllSettingsauth($company_id)->where('name', $key)->count();
    }
    /**
     * Get the validation rules for setting fields.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get the data type of a setting.
     *
     * @param $field
     *
     * @return mixed
     */
    public static function getDataType($field)
    {
        $type = self::getDefinedSettingFields()
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get default value for a setting.
     *
     * @param $field
     *
     * @return mixed
     */
    public static function getDefaultValueForField($field)
    {
        return self::getDefinedSettingFields()
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * Get default value from config if no value passed.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    private static function getDefaultValue($key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Get all the settings fields from config.
     *
     * @return Collection
     */
    private static function getDefinedSettingFields()
    {
        return collect(config('setting_fields'))->pluck('elements')->flatten(1);
    }

    /**
     * caste value into respective type.
     *
     * @param $val
     * @param $castTo
     *
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }

    /**
     * Get all the settings.
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
      ///  return Cache::rememberForever('settings', function () {
        $session = Session::get('tenant_impersonation');
        if (isset($session))
            $tenant = $session;
        elseif (auth()->check())
            $tenant = auth()->user()->company_id;
        else
            $tenant=1;
        $company = Company::withoutGlobalScope('company_id')->where('id', $tenant)->first();
        if(Auth::guard('customers')->check())
        {
            $tenant=Auth::guard('customers')->user()->company_id;
            if($tenant==null)
                $tenant=1;
            $company = Company::withoutGlobalScope('company_id')->where('id', $tenant)->first();

        }
        $root=$company->getRoot();
            return self::withoutGlobalScope('company_id')->where('company_id',$company->id)->get();
       // });
    }
    public static function getAllSettingsauth($company_id)
    {
      // return Cache::rememberForever('settings', function () use ($company_id){
       
       $setting=self::withoutGlobalScope('company_id')->where('company_id',$company_id)->get();

       return $setting;
      // });
    }
    /**
     * Flush the cache.
     */
    public static function flushCache()
    {
        Cache::forget('settings');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }
}
