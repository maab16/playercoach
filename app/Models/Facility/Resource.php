<?php

namespace App\Models\Facility;

use App\Facility\Booking;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $casts = [
    	'business_hours' => 'array'
    ];

    protected $fillable = [
    	'booking_id',
    	'title',
    	'type',
    	'business_hours',
    ];

    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }
}
