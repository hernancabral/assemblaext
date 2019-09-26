<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Planning extends Model
{
    protected $guarded=[];

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function tickets() {
        return $this->belongsToMany(Ticket::class);
    }

    use Search;
}
