<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
    	$users = User::all();

    	return view('users.index', compact('users'));
    }

    public function showCreateForm()
    {
    	return view('users.add');
    }
}
