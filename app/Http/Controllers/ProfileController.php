<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use App\Traits\HttpResponses;
// use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    use HttpResponses;

    public function updateProfile(ProfileUpdateRequest $request){
        $request->validated($request->all());
        // $user = User::where('id',$request('id'))->first();
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $profile = $user->profile;
        $profile->phone = $request->phone;
        $profile->gender = $request->gender;
        $profile->bio = $request->bio;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->country = $request->country;
       
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $fileName = time().'_'.$file->getClientOriginalName(); 
       
            $request->file->move(public_path('uploads'), $fileName);
          // Store the file in the 'uploads' directory
             $user->profile->user_mage =   $path;
        }
        $user->save();
        $profile->save()
      return  $this->success($user,'Profile updated successfully.');
    }

    public function updateProfilePreference(ProfilePreferencRequest $request){
        $request->validated($request->all());
        $user = Auth::user()->profile;
        $user->feed_preferences = ['preferred_authors' =>$request->prefered_authors,'preferred_sources' => $request->preferred_sources];
        $user->save();
        return  $this->success($user,'Profile preference updated successfully.');
    }
}
