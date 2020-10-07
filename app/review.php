<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    public function item()
    {
        return $this->belongsTo(item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
