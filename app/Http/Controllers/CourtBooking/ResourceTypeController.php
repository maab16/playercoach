<?php

namespace App\Http\Controllers\CourtBooking;

use App\Http\Controllers\Controller;
use App\Models\CourtBooking\ResourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceTypeController extends Controller
{

	/**
     * Get all created resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        $resource_types = ResourceType::all();
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
        $resourceType = new ResourceType;
        $resourceType->user_id = Auth::user()->id;
        $resourceType->title = $request->title;
        if($resourceType->save()) {
            return response()->json(["success" => true, 'ResourceType' => $resourceType]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create ResourceType"]]);
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
        $resourceType = ResourceType::find($id);
        $resourceType->title = $request->title;
        if($resourceType->update()) {
            return response()->json(["success" => true]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with updated resourceType"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($resourceType = ResourceType::find($id)) {
            $resourceType->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["resourceType not found"]]);
    }
}
