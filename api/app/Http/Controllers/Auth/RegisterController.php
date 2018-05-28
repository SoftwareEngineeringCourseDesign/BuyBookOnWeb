<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\LoginController;
use App\Models\Role;
use App\Models\User;
use http\Env\Request;

class RegisterController extends Controller
{

    public function __construct()
    {
        //
    }

    public function handle(Request $request) {
        $this->validate($request, [
            'username' => 'require|string|unique:user,username',
            'password' => 'require|string|regex:/^[A-Za-z0-9]{40}$/',
            'email' => 'require|string|unique:user,email'
        ]);

        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role()->associate(Role::where(['alias' => 'person'])->first());
        $user->save();
        $loginController = new LoginController();
        return $loginController->handle($request);
    }
}
