<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','roles','bio','phone','gender','user_image','city','state','country','preferred_authors','preferred_sources'];
    
      /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'account_status',
    ];
   
     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
        'preferred_authors' => 'array',
        'preferred_sources' => 'array',
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
