<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Tag extends Model
{
    protected $fillable = ['code', 'name'];

    public function plannings()
    {
        return $this->hasMany('App\Planning');
    }

    public function tickets() {
        return $this->belongsToMany(Ticket::class);
    }

    use Search;
}
