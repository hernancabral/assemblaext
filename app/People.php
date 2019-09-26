<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class People extends Model
{
    protected $table="people";
    protected $guarded=[];
    
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function assigned()
    {
        return $this->hasMany(Ticket::class, 'assigned_id');
    }

    public function tester()
    {
        return $this->hasMany(Ticket::class, 'tester_id');
    }

    public function leads()
    {
        return $this->hasMany('App\Team', 'leader_id');
    }

    public function prioritized()
    {
        return $this->hasMany(Prioritized::class, 'people_id');
    }

    use Search;
}
