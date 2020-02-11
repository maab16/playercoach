<?php

namespace App\Models\CourtBooking;

use App\Models\CourtBooking\ResourceType;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	protected $casts = [
		'business_hours' => 'array'
	];
	
    protected $fillable = [
    	'booking_sheet_id',
    	'resource_type_id',
    	'title',
    	'business_hours'
    ];

    public function resource_type()
    {
        return $this->belongsTo(ResourceType::class);
    }
}
