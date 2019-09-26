<?php

namespace App\Traits;

trait Search {

    public function scopeSearch($query, $filtro, $foreign = null)
    {
    if ($filtro == null) return $query;
    unset($filtro['perPage'], $filtro['page']);
    foreach ($filtro as $campo => $input) {
        if ($input != null) {
            if (isset($foreign) && array_key_exists($campo, $foreign)){

                $query->whereHas($foreign[$campo][1], function($q) use($input,$campo, $foreign) {
                    $q->where($foreign[$campo][0], 'like', '%' . $input . '%');
                });
            } else {
                $query->where($campo, 'LIKE', '%'.$input.'%');
            }
        }
    }
    return $query;
    }
}