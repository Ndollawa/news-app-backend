<?php

namespace App\Http\Controllers\v1\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Profile\ProfileUpdateRequest;
use App\Http\Requests\v1\Profile\ProfilePreferenceRequest;
use App\Traits\v1\HttpResponses;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HttpResponses;
// ProfileUpdate
    public function updateProfile(Request $request)
    {
        // return $this->success(json_encode($request->user_image['name']));
        // $request->validated($request->all());
    
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
    
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
            $path = $file->move(public_path('uploads'), $fileName);
            $profile->user_image = $path;
        }
    
        $profile->save();
    
        return $this->success($user, 'Profile updated successfully.');
    }
    // ProfilePreference
    public function updateProfilePreference(Request $request)
    {
        // $request->validated($request->only(['preferred_authors','preferred_sources']));
        $profile = Auth::user()->profile;
        $profile->update([
            // "feeds_preferences" => [
            'preferred_authors' => $request->preferred_authors,
            'preferred_sources' => $request->preferred_sources,
        // ]
        ]);
    
        return $this->success($profile, 'Profile preference updated successfully.');
    }
}
