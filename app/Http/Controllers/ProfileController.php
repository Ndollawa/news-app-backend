<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Traits\HttpResponses;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    use HttpResponses;

    public function updateProfile(ProfileUpdateRequest $request){
        $request->validated($request->all());
        $user = User::where('id',$request('id'))->first();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->paasword = Hash::make($request->paasword);
        }
        $user->profile->phone = $request->phone;
        $user->profile->gender = $request->gender;
        $user->profile->bio = $request->bio;
        $user->profile->city = $request->city;
        $user->profile->state = $request->state;
        $user->profile->country = $request->country;
       
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $fileName = time().'_'.$file->getClientOriginalName(); 
       
            $request->file->move(public_path('uploads'), $fileName);
          // Store the file in the 'uploads' directory
             $user->profile->user_mage =   $path;
        }
        $user->save();
      return  $this->success($user,'Profile updated successfully.');
    }

    public function updateProfilePreference(ProfilePreferencRequest $request){
        $request->validated($request->all());
        $user = User::where('id',$request('id'))->first();
        $user->profile->feed_preferences = ['preferred_authors' =>$request->prefered_authors,'preferred_sources' => $request->preferred_sources];
        $user->save();
        return  $this->success($user,'Profile preference updated successfully.');
    }
}
