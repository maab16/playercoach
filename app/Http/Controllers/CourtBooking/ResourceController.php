<?php

namespace App\Http\Controllers\CourtBooking;

use App\Http\Controllers\Controller;
use App\Models\CourtBooking\BookingSheet;
use App\Models\CourtBooking\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{

	/**
     * Get all created resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        $resource_types = Resource::all();
        return response()->json([
            'success' => true, 
            'resource_types' => $resource_types,
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
        // return response()->json(["success" => true, 'data' => request()->all()]);
        $resource = new Resource;
        $resource->booking_sheet_id = $request->booking_sheet_id;
        $resource->resource_type_id = $request->resource_type['id'];
        $resource->title = $request->title;
        $resource->business_hours = $request->business_hours;
        if($resource->save()) {
            $published_booking = BookingSheet::with('resources')->where('id', $request->booking_sheet_id)->first();
            return response()->json(["success" => true, 'booking' => $published_booking]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create Resource"]]);
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
        $resource = Resource::find($id);
        $resource->booking_sheet_id = $request->booking_sheet_id;
        $resource->resource_type_id = $request->resource_type_id;
        $resource->title = $request->title;
        $resource->business_hours = $request->business_hours;
        if($resource->update()) {
            $published_booking = BookingSheet::with('resources')->where('id', $request->booking_sheet_id)->first();
            return response()->json(["success" => true, 'booking' => $published_booking]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create Resource"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($resource = Resource::find($id)) {
            $resource->delete();
           $published_booking = BookingSheet::with('resources')->where('id', $request->id)->first();
            return response()->json(["success" => true, 'booking' => $published_booking]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Resource not found"]]);
    }
}
