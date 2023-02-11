<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Helper\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileStoreRequest;
use App\Models\UserInfo;

class ProfileController extends Controller
{
    public function index(){
        $user = User::with('userInfo')->find(Auth::id());
        return view('admin.pages.profile.index',compact('user'));
    }

    public function updateProfile(ProfileStoreRequest $request){

        $user = User::find($request->id)->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $userInfo = UserInfo::where('user_id',$user->id)->first();
        // dd($userInfo);

        if($userInfo==null){
            UserInfo::create([
            'user_image' => Helpers::upload('uploads/users/', 'png', $request->file('user_image')),
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'state' => $request->state,
            'zipCode' => $request->zipCode,
            ]);
        }else{
            UserInfo::where('id',$userInfo->id)->update([
            'user_image' => $request->has('user_image') ? Helpers::update('uploads/users/', $userInfo->user_image, 'png', $request->file('user_image')) : $userInfo->user_image,
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'state' => $request->state,
            'zipCode' => $request->zipCode,
        ]);
        }



        return back();
    }
}
