<?php

namespace App\Models\CourtBooking;

use App\Models\CourtBooking\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSheet extends Model
{
    use SoftDeletes;

    protected $table = 'booking_sheets';

    protected $casts = [
    	'settings' => 'array'
    ];

    protected $fillable = [
    	'user_id',
    	'title',
    	'settings',
    ];

    public function resources()
    {
    	return $this->hasMany(Resource::class, 'booking_sheet_id')->with('resource_type');
    }
}
