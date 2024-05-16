<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Session;

use App\User;

class UserController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255|min:3',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'type' => 'required|in:admin,superadmin',
        'status' => 'required|boolean'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('superadmin')) {
            $users = User::orderBy('name', 'asc')->paginate(20);

            return view('admin.user.list', compact('users'));
        }
    }

    public function create()
    {
        if (Gate::allows('superadmin')) {
            $user = new User;
            $user->status = 1;
            $user->type = 'admin';

            return view('admin.user.form', compact('user'));
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('superadmin')) {
            $this->validate($request, $this->rules);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request['password']);
            $user->type = $request->type;
            $user->status = $request->status;

            $user->save();

            Session::flash('alertText', 'Dados inseridos com sucesso!');
            return redirect( route('admin.user.index') );
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Gate::allows('superadmin')) {
            $user = User::find($id);

            return view('admin.user.form', compact('user'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Gate::allows('superadmin')) {
            $user = User::find($id);

            $rules = $this->rules;
            $rules['email'] = 'required|string|email|max:255|min:3|unique:users,email,'.$id;
            $rules['password'] = 'nullable|string|min:6|confirmed';

            $this->validate($request, $rules);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->status = $request->status;

            if($request->password){
                $user->password = bcrypt($request['password']);
            }

            $user->save();

            Session::flash('alertText', 'Dados editados com sucesso!');
            return redirect( route('admin.user.index') );
        }
    }

    public function destroy($id)
    {
        if (Gate::allows('superadmin')) {
            if($id > 1)
            {
                $user = User::find($id);
                $user->delete();

                Session::flash('alertText', 'Dados removidos com sucesso!');            
            }
            return redirect( route('admin.user.index') );
        }
    }

    public function status($id)
    {
        if (Gate::allows('superadmin')) {
            $user = User::find($id);

            $status = ($user->status) ? false : true;
            $user->status = $status;

            $user->save();

            Session::flash('alertText', 'Status alterado com sucesso!');
            return redirect( route('user.index') );
        }
    }
}
