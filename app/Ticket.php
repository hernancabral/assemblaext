<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Ticket extends Model
{
    protected $guarded=[];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function plannings() {
        return $this->belongsToMany(Planing::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function assigned()
    {
        return $this->belongsTo(People::class);
    }

    public function tester()
    {
        return $this->belongsTo(People::class);
    }

    public function prioritized()
    {
        return $this->hasOne(Prioritized::class, 'ticket_id');
    }

    use Search;
}
