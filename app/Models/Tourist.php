<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tourist extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];


        public function tourApplications()
    {
        return $this->hasMany(TourApplication::class);
    }
}
