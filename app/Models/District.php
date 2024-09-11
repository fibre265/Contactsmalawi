<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public function townships()
    {
        return $this->hasMany('App\Township');
    }
    public function region()
    {
       // return $this->belongsTo('App\Region');
        return $this->belongsTo(Region::class);
    }
    public function user()
{
    return $this->hasMany(User::class);
}
}
