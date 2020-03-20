<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    public function items()
    {
        return $this->belongsToMany(item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
