<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TicketMessages extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function admin(){
        return $this->belongsTo("App\Models\User","created_by","id");
    }
    public function customer(){
        return $this->belongsTo("App\Models\Subscriber","created_by","id");
    }

}
