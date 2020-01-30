<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getLogin ()
	{
        // return bcrypt('admin');
		return view('admin.login');
    }
    
    public function postLogin (Request $request)
	{
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required'
		]);

		if (!Auth::attempt(['username' => $request['username'], 'password' => $request['password']]) AND !Auth::attempt(['email' => $request['username'],'password' => $request['password']])) {
			return redirect()->back()->with(['fail' => 'The username/email and password you entered did not match.']);
		}

		return redirect()->route('admin.setoran');
    }
    
    public function getLogout ()
	{
		Auth::logout();
		return redirect()->route('admin.login');
	}
}
