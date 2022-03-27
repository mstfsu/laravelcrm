<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //protected $table = 'countries';

    public $timestamps = false;

    public function countries()
    {
        return $this->hasOne('App\Model\Country', 'id', 'country_id');
    }
}
