<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Prioritized extends Model
{
    protected $table="prioritized";
    protected $guarded=[];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    use Search;
}
