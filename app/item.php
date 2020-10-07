<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    public function images()
    {
        return $this->hasMany(image::class);
    }
    public function orders()
    {
        return $this->belongsToMany(order::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function reviews()
    {
        return $this->hasMany(review::class);
    }
}
