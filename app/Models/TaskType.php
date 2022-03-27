<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;

class TaskType extends Model
{
    use HasFactory, BelongsToTenants;
    protected $guarded = [];
    public $tenantColumns = ['company_id'];


    protected $table = 'task_types';

    public function subjects(){
        return $this->hasMany(TaskSubjects::class)->with('priority:id,name');
    }
    public function tasks(){
        return $this->hasMany(Task::class, 'task_type_id','id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
