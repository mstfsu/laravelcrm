<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMazer\Samehouse\BelongsToTenants;

class Task extends Model
{
    use HasFactory,BelongsToTenants;
    protected $guarded = [];
    public $tenantColumns = ['company_id'];


    public function subject()
    {
        return $this->belongsTo('App\Models\TaskSubjects', 'task_subject_id', 'id')->withoutGlobalScope('company_id');
    }
    public function agent()
    {
        return $this->belongsTo('App\Models\Agent', 'assigned_agent', 'id')->withoutGlobalScope('company_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\TaskType', 'task_type_id', 'id')->withoutGlobalScope('company_id');
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
    public function ticket()
    {
        return $this->belongsTo(Ticket::class)->with('subject')->with('priority')->with('customer')->with('status')->with('type')->with('assigned_user')->withoutGlobalScope('company_id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withoutGlobalScope('company_id');
    }
}
