<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
	public function index() {
		$user = User::all();
		return $user;
	}
	public function show($id) {
    	$user = User::with('galleries')->with('comments')->findOrFail($id);
        return $user;
    }
}
