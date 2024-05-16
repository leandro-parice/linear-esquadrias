<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$user = Auth::user();

    	return view('admin.profile.index', compact('user'));
    }

	public function update(Request $request)
    {
    	$user = Auth::user();

    	$this->validate($request, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
			'password' => 'nullable|string|min:6|confirmed',
		]);

		$user->name = $request->name;
		$user->email = $request->email;
		if($request->password){
			$user->password = bcrypt($request->password);
		}
		$user->save();
		
		return redirect()->route('admin.profile')->with( ['success' => 'Dados salvos com sucesso!'] );
    }
}
