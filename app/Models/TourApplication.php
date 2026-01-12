<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tourist_id',
        'tour_package_id',
        'phone',
        'address',
        'city',
        'emergency_contact',
        'note_name',
        'special_note',
        'status',
        'payment_status',
        'final_amount',
        'dues',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

     public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }
}
