<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    //
    protected $table = 'crm_traces';

    public function client()
    {
        return $this->hasOne('App\Client', 'id', 'client_id');
    }

    public function service()
    {
        return $this->hasOne('App\User', 'id', 'service_id');
    }
}
