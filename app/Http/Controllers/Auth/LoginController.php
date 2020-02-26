<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $user = User::where('nickname',$request["nickname"])->where('password',$request["password"])->first();
        if ($user){
            $user_auth=JWTAuth::fromUser($user);
            return response()->json(["token"=>$user_auth, "type" => "bearer", "expires_in" => 3000, "status" => true]);
        }else{
            return response()->json(["status" => false, "msg" => "Error de autenticación"]);
        }
    }

    public function me()
    {
       return response()->json(auth()->user());
    }

}
