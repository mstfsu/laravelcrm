<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;


class ClassificationGroup extends Model
{
    use HasFactory,BelongsToTenants;
    public $tenantColumns = ['company_id'];

    protected $guarded=[];
    public function admins(){
        return $this->belongsToMany(User::class,"admin_groups","classification_group_id","user_id")->withPivot(["level_name"]);
    }
    public function agents(){
        return $this->belongsToMany(Agent::class,"agents_group","group_id","agent_id")->withPivot(["level_name"]);
    }
    public function tickets(){
        return $this->hasMany('App\Models\Ticket','group_id','id');

    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
