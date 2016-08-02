<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return view('user.welcome');
        } else {
            return view('user.login');
        }
    }

    public function getAll()
    {
        if (Auth::user()) {
            $users = User::where('is_active',true)->get();

            if (Auth::user()->role == Constants::ROLE_ADMIN) {
                return view('user.admin.index', ['users' => $users]);
            } else {
                abort(403);
            }
        } else {
            return redirect('/');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request['username'];
        $password = $request['password'];

        if (Auth::attempt(['username' => $username, 'password' => $password, 'is_active' => true])) {
            return redirect('/');
        } else {
            return redirect('/')->with('message','Username atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function create(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $this->validate($request, [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'role' => 'required|in:ADMIN,BRANCH'
            ]);

            $name = $request['name'];
            $username = $request['username'];
            $password = $request['password'];
            $role = $request['role'];

            User::create([
                'name' => $name,
                'username' => $username,
                'password' => bcrypt($password),
                'role' => $role,
                'is_active' => true
            ]);

            return redirect('/user');
        } else
            abort(403);
    }

    public function update(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $this->validate($request, [
                'id' => 'required',
                'name' => 'required',
                'username' => 'required',
                'role' => 'required|in:ADMIN,BRANCH'
            ]);

            $id = $request['id'];
            $name = $request['name'];
            $username = $request['username'];
            $password = $request['password'];
            $role = $request['role'];

            try {
                DB::beginTransaction();

                $user = User::find($id);
                $user->name = $name;
                $user->username = $username;
                if (!empty($password))
                    $user->password = bcrypt($password);
                $user->role = $role;
                $user->save();

                DB::commit();

                return redirect('/user');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function delete(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            try {
                DB::beginTransaction();

                $user = User::find($request['id']);
                $user->is_active = false;
                $user->save();

                DB::commit();

                return redirect('/user');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }
}
