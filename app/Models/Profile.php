<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','bio','phone','gender','user_image','city','state','country','feeds_preference'];
    
      /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'roles',
        'account_status',
    ];
   
     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
        'feeds_preference' => 'array',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
  

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
