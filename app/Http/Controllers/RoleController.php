<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return response()->json(["success" => true, 'roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRolePermissions(Request $request, $id)
    {
        $role = Role::find($id);
        return response()->json(["success" => true, 'permissions' => $role->permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.new', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role;
        $role->name = $request->name;
        if($request->guard_name) {
            $role->guard_name = $request->guard_name;
        }
        if($role->save()) {
            // $ids = [];
            // foreach ($request->permissions as $permission) {
            //     $ids[] = $permission['id'];
            // }
            $role->givePermissionTo($request->permissions);
            return response()->json(["success" => true, 'role' => $role]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create role"]]);
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
        $role = Role::find($id);
        $role->name = $request->name;
        if($request->guard_name) {
            $role->guard_name = $request->guard_name;
        }
        if($role->update()) {
            // $ids = [];
            // foreach ($request->permissions as $permission) {
            //     $ids[] = $permission['value'];
            // }
            $role->syncPermissions($request->permissions);
            return response()->json(["success" => true, 'role' => $role]);
        }

        return response()->json(["success" => true, 'errors' => ["There has an error with create role"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($role = Role::find($id)) {
            $role->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Role not found"]]);
    }
}
