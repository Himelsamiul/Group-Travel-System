<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    protected $fillable = [
        'package_title',
        'short_description',
        'full_description',
        'booked',
        'place_id',

        'start_date',
        'end_date',

        'max_persons',
        'min_persons',
        'available_seats',

        'price_per_person',
        'discount',

        'hotel_id',
        'transportation_id',

        'included_items',
        'excluded_items',

        'thumbnail_image',

        'status',
    ];

    /* ===============================
       Relationships
    =============================== */

    public function place()
    {
        return $this->belongsTo(\App\Models\Place::class);
    }

    public function hotel()
    {
        return $this->belongsTo(\App\Models\Hotel::class);
    }

    public function transportation()
    {
        return $this->belongsTo(\App\Models\Transportation::class);
    }

    // App\Models\TourPackage.php

public function tourApplications()
{
    return $this->hasMany(TourApplication::class);
}

}
