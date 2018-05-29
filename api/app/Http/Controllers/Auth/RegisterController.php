<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;


class RegisterController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request) {
        $this->validate($request, [
            'username' => 'required|string|unique:user,username|alpha_dash',
            'password' => 'required|string|regex:/^[A-Za-z0-9]{40}$/',
            'email' => 'required|string|unique:user,email'
        ]);

        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role()->associate(Role::where(['alias' => 'person'])->first());
        $user->save();
        $loginController = new LoginController();
        return $loginController->handle($request);
    }
}
