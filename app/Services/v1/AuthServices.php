<?php
namespace App\Services\v1;

use App\Models\User;
use App\Models\v1\Profile;
use App\Traits\v1\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\Roles;

class AuthServices 
{
    use HttpResponses;

/**
 * Registers a new user and returns the created user Object
 * @param $request validated user credentials
 * @return $user created user object
 */

public function registerUser($request){
    $user = new User([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    $user->save();
    
    // Create a new profile for the user
    // $profile = new Profile();
    // dd($profile);
    $user->profile()->create([
        'roles' => [Roles::USER->value],
        'preferred_authors' => [],
        'preferred_sources' => [],
        ]);
    return  $user;
}

/**
 * Login a user with given credentials
 * @param $request validated user credentials
 * @return $user created user object
 */
public  function loginUser($request){
    
    if ( !$token = Auth::attempt($request->only('email', 'password'))) {
        return $this->error(null,'Invalid credentials',401);
     }
   return  $user = Auth::user(); 

}

}




?>