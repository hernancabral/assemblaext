<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Team extends Model
{
    protected $guarded=[];

    public function people()
    {
        return $this->hasMany('App\People');
    }

    public function leader()
    {
        return $this->belongsTo('App\People', 'leader_id');
    }

    public function planning()
    {
        return $this->hasMany('App\Planning');
    }

    public function priorities()
    {
        return $this->hasMany('App\Prioritized');
    }

    use Search;
}
