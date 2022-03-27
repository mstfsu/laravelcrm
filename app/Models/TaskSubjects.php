<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;


class TaskSubjects extends Model
{
    use HasFactory, BelongsToTenants;
    protected $table = 'task_subjects';
    protected $guarded = [];
    public $tenantColumns = ['company_id'];


    public function priority(){
        return $this->belongsTo(Priority::class);
    }
    public function tasks(){
        return $this->hasMany('App\Models\Task','task_subject_id','id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
