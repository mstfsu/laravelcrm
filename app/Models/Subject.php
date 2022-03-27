<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;

class Subject extends Model
{
    use HasFactory,BelongsToTenants;
    protected $guarded = [];
    public $tenantColumns = ['company_id'];

    public function priority(){
        return $this->belongsTo(Priority::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function tickets(){
        return $this->hasMany('App\Models\Ticket','subject_id','id');

    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
