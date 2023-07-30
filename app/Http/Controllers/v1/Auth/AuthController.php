<?php

namespace App\Http\Controllers\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\v1\HttpResponses;
use App\Http\Requests\v1\Auth\UserRegistrationRequest;
use App\Http\Requests\v1\Auth\UserLoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Services\v1\AuthServices;

class AuthController extends Controller
{
    // private $authServices;
    // public function __construct()
    // {
    //     $this->authServices = new AuthServices();
    
    // }
   
/**
  * Registers and login a  User
  *
  * @return \Illuminate\Http\JsonResponse
  */
 
        use HttpResponses;

    public function register(UserRegistrationRequest $request, AuthServices $AuthService)
    {
        $request->validated($request->all());
        $user = $AuthService->registerUser($request);
            // Create JWTs
        return $this->getUserToken($user);
    }
    
  /**
  * Login and authenticate a  User given a list of credentials and generates accessToken
  *
  * @return \Illuminate\Http\JsonResponse
  */

public function login(UserLoginRequest $request, AuthServices $AuthService)
    {
        $request->validated($request->all());
        $user = $AuthService->loginUser($request);
       return $this->getUserToken($user);
  }


  /**
  * Log outs the authenticated User and invalidates token
  *
  * @return \Illuminate\Http\JsonResponse
  */

    public function logout()
    {
         Auth::logout();
        return $this->success(null,'Successfully logged out');
    }

  /**
  * Get the authenticated User
  *
  * @return \Illuminate\Http\JsonResponse
  */

    public function userProfile()
    {
        $user = Auth::user();
        return $this->success($user);
    }

  /**
  * Refresh a token
  *
  * @return \Illuminate\Http\JsonResponse
  */

    public function refresh(Request $request)
    {

       $accessToken = Auth::refresh();
       $cookie = cookie('jwt', $accessToken, 1440,null,null,true, true,'None'); // Create a secure cookie
       return $this->success([
               //   'user' => $user,
               'authorization' => [
                   'token' => $accessToken,
                   'type' => 'bearer',
               ]
               ],
               null,
               201)->cookie($cookie);
    }
    /**
 * Generates user jwt access token
 * @param authenticated user credentials
 * @return $accessToken from user object
 */
public  function getUserToken($user){
    
    $customClaims = [
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'profile' => $user->profile
        ]
    ];

    $accessToken = JWTAuth::claims($customClaims)->fromUser($user);
    // Create secure cookie with new accessToken
        
    $cookie = cookie('jwt', $accessToken, 1440,null,null,true, true,'None'); // Create a secure cookie
    return $this->success([
            //   'user' => $user,
            'authorization' => [
                'token' => $accessToken,
                'type' => 'bearer',
            ]
            ],
            null,
            201)->cookie($cookie);
}

}
