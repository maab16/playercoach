<?php

namespace App\Http\Controllers\Facility;

use App\Facility\Booking;
use App\Http\Controllers\Controller;
use App\Models\Facility\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Get all created resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $resources = Resource::with('booking')->get();
        $bookings = Booking::all();
        return response()->json(["success" => true, 'resources' => $resources,'bookings' => $bookings]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// return response()->json(["success" => false, "data" => $request->booking['id']]);

        $resource = new Resource;
        $resource->booking_id = $request->booking['id'];
        $resource->title = $request->title;
        $resource->type = $request->type;
        $resource->business_hours = json_decode($request->business_hours, true);
        if($resource->save()) {
            return response()->json(["success" => true, 'resource' => $resource]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create resource"]]);
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
        $resource->booking_id = $request->booking['id'];
        $resource->title = $request->title;
        $resource->type = $request->type;
        $resource->business_hours = json_decode($request->business_hours, true);
        if($resource->update()) {
            return response()->json(["success" => true, 'resource' => $resource]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create resource"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($resource = Resource::find($id)) {
            $resource->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Booking not found"]]);
    }
}
