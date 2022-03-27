<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use NunoMazer\Samehouse\BelongsToTenants;

class Ticket extends Model
{
    use HasFactory,BelongsToTenants;
    protected $guarded = [];
    public $tenantColumns = ['company_id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Subscriber', 'customer_id', 'id')->withoutGlobalScope('company_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class)->withoutGlobalScope('company_id');
    }
    public function assigned_user()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to', 'id')->withoutGlobalScope('company_id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class)->withoutGlobalScope('company_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class)->withoutGlobalScope('company_id');
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class)->withoutGlobalScope('company_id');
    }
    public function group()
    {
        return $this->belongsTo(ClassificationGroup::class)->withoutGlobalScope('company_id');
    }
    public function watchers()
    {
        return $this->belongsToMany('App\Models\User', 'ticket_watcher', 'ticket_id', 'user_id')->withoutGlobalScope('company_id');
    }
    public function messages()
    {
        return $this->hasMany(TicketMessages::class)->withoutGlobalScope('company_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->with(['agent','status','subject','priority'])->withoutGlobalScope('company_id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::flush();
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
