<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['country', 'name', 'note ,status'];


    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
