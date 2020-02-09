<?php

namespace App\Facility;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
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
