<?php

namespace App\Models\Facility;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourtBooking extends Model
{
    use SoftDeletes;

    protected $table = 'court_bookings';

    protected $fillable = [
    	'user_id',
    	'start',
    	'end',
    	'resourceId',
    	'resourceIds',
    	'title',
    	'open',
    	'max_participants',
    	'created_by',
    	'updated_by',
    ];
}
