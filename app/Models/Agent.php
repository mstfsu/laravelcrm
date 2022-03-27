<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;

class Agent extends Model
{
    use HasFactory,BelongsToTenants;
    public $tenantColumns = ['company_id'];

    protected $casts = [
        'work_hours' => 'array',
    ];
    protected $guarded=[];

    public function map_infos(){
        return $this->hasMany('App\Models\AgentMapInfo','agent_id','id');

    }
    public function tasks(){
        return $this->hasMany('App\Models\Task','assigned_agent','id')->with(['agent','status','subject','priority','group','ticket','type']);

    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
