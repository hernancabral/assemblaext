<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Milestone extends Model
{
    protected $fillable = ['monitor'];

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    use Search;
}

