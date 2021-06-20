<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedUsers extends Controller
{
    function __construct()
    {
        $this->middleware('auth');    
    }
    public function profile($username)
    {
        return view('users.profile');
    }
}
