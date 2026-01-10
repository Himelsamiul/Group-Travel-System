<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
protected $fillable = [
    'transport_name',
    'type',
    'status',
    'note',
];

}
