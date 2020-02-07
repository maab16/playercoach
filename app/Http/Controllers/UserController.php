<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
    	$users = User::all();

    	return view('users.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = User::with(['roles'])->get();
        $roles = Role::all();
        return response()->json(["success" => true, 'users' => $users, 'roles' => $roles]);
    }

    public function showCreateForm()
    {
    	return view('users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// return response()->json(["success" => true, 'roles' => $request->roles]);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }

            return response()->json([
	            'success' => false,
	            'errors' => $errors,
	        ]);
        }

	    $user = new User;
	    $user->name = $request->name;
	    $user->email = $request->email;
	    $user->password = Hash::make($request->password);

	    if($user->save()) {
	    	$user->assignRole($request->roles);
	    	return response()->json(["success" => true]);
	    }

        return response()->json(["success" => false, 'errors' => ["There has an error with create role"]]);
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }

            return response()->json([
	            'success' => false,
	            'errors' => $errors,
	        ]);
        }

	    $user = User::find($id);
	    $user->name = $request->name;
	    $user->email = $request->email;
	    if($request->password) {
	    	$user->password = Hash::make($request->password);
	    }

	    if($user->update()) {
	    	$ids = [];
	    	foreach($request->roles as $role) {
	    		$ids[] = $role['id'];
	    	}
	    	$user->syncRoles($ids);
	    	return response()->json(["success" => true]);
	    }

        return response()->json(["success" => false, 'errors' => ["There has an error with create role"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($user = User::find($id)) {
            $user->delete();
            return response()->json(["success" => true]);
        }
        
        return response()->json(["success" => false, 'errors' => ["Role not found"]]);
    }
}
