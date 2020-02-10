<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Models\Facility\CourtBooking;
use App\Models\Facility\Resource;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function all()
    {
    	$resources = Resource::all();
    	$court_bookings = CourtBooking::all();

    	return response()->json([
    		'success' => true,
    		'resources' => $resources,
    		'court_booking' => $court_bookings
    	]);
    }
}
