<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;

class Brand extends Model
{
    protected $fillable = ['code', 'name'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    use Search;
}
