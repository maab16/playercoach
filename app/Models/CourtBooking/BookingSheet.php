<?php

namespace App\Models\CourtBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSheet extends Model
{
    use SoftDeletes;

    protected $casts = [
    	'settings' => 'array'
    ];

    protected $fillable = [
    	'user_id',
    	'title',
    	'settings',
    ];
}
