<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Profile;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
    ];
    
    //   /**
    //  * Creates an account profile for every registered user   .
    //  *
    //  * @return mixed
    //  */
    // public static function boot() {
    //     parent::boot();
    //     self::created(function($user){
    //         $profile = new Profile();
    //         $profile->user_id = $user->id;
    //             $profile->user_image = '';
    //             $profile->gender = null;
    //             // $profile->prefernce = '{}';
    //             // $profile->roles = '{}';
    //             $profile->city = '';
    //             $profile->state = '';
    //             $profile->country = '';          
    //             $profile->save();
    //     });
    // }
     
    public function profile()
    {
        return $this->hasOne(Profile::class,'user_id','id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    
}
