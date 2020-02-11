<?php

namespace App\Models\Facility;

use App\Models\CourtBooking\BookingSheet;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $casts = [
    	'business_hours' => 'array'
    ];

    protected $fillable = [
    	'booking_sheet_id',
    	'title',
    	'type',
    	'business_hours',
    ];

    public function booking_sheet()
    {
    	return $this->belongsTo(BookingSheet::class);
    }
}
