<?php

namespace App\Http\Controllers\Facility;

use App\Facility\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
	public function index()
	{
		return "Working";
	}

	/**
     * Get all created resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $bookings = Booking::withTrashed()->get();
        $unpublished_bookings = Booking::onlyTrashed()->get();
        $published_bookings = Booking::all();
        return response()->json([
            'success' => true, 
            'bookings' => $bookings, 
            'unpublished_bookings' => $unpublished_bookings, 
            'published_bookings' => $published_bookings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// return response()->json(["success" => false, "data" => json_decode($request->settings, true)]);

        $booking = new Booking;
        $booking->user_id = Auth::user()->id;
        $booking->title = $request->title;
        $booking->settings = json_decode($request->settings, true);
        if($booking->save()) {
            return response()->json(["success" => true, 'booking' => $booking]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create booking"]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->title = $request->title;
        $booking->settings = json_decode($request->settings, true);
        if($booking->update()) {
            return response()->json(["success" => true, 'booking' => $booking]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with updated booking"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request,$id)
    {
        if($booking = Booking::withTrashed()->where('id',$id)->first()) {
            $booking->restore();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Booking not found"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($booking = Booking::find($id)) {
            $booking->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Booking not found"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanent($id)
    {
        if($booking = Booking::withTrashed()->where('id',$id)->first()) {
            $booking->forceDelete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Booking not found"]]);
    }
}
