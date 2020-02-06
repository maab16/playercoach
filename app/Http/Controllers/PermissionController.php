<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $permissions = Permission::all();
        return response()->json(["success" => true, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required'
        // ]);

        $permission = new Permission;
        $permission->name = $request->name;
        if($request->guard_name) {
            $permission->guard_name = $request->guard_name;
        }
        if($permission->save()) {
             return response()->json(["success" => true, 'permission' => $permission]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create permission"]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $permission = Permission::find($id);
        $permission->name = $request->name;
        if($request->guard_name) {
            $permission->guard_name = $request->guard_name;
        }
        if($permission->update()) {
             return response()->json(["success" => true, 'permission' => $permission]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create permission"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($permission = Permission::find($id)) {
            $permission->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Permission not found"]]);
    }
}
