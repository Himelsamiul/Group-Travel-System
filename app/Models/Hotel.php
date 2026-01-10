<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'stars',
        'note',
        'status',
    ];


    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
