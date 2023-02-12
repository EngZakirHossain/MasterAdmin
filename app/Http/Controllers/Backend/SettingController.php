<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helpers;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\GeneralSettingUpdateRequest;
use App\Http\Requests\SocialMediaSettingUpdateRequest;

class SettingController extends Controller
{
    public function general(){
        return view('admin.pages.settings.general');
    }
    public function generalUpdate(GeneralSettingUpdateRequest $request){

        Setting::updateOrCreate([
            'key' => 'site_title',
            'value' => $request->site_title,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_address',
            'value' => $request->site_address,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_email',
            'value' => $request->site_email,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_phone',
            'value' => $request->site_phone,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_description',
            'value' => $request->site_description,
        ]);
        //company logo
        $companyLogo = Setting::where('key','site_logo')->first();
        if($companyLogo != null){
            $companyLogo->update([
                'value' => $request->has('site_logo') ? Helpers::update('uploads/company/', $companyLogo->value, 'png', $request->file('site_logo')) : $companyLogo->value,
            ]);
        }else{
            Setting::updateOrCreate([
                'key' => 'site_logo',
                'value' => Helpers::upload('uploads/company/', 'png', $request->file('site_logo')),
            ]);
        }
        //company favicon
        $companyFavicon = Setting::where('key','site_favicon')->first();
        if($companyFavicon != null){
            $companyFavicon->update([
                'value' => $request->has('site_favicon') ? Helpers::update('uploads/company/', $companyFavicon->value, 'png', $request->file('site_favicon')) : $companyFavicon->value,
            ]);
        }else{
            Setting::updateOrCreate([
                'key' => 'site_favicon',
                'value' => Helpers::upload('uploads/company/', 'png', $request->file('site_favicon')),
            ]);
        }


        Toastr::success('Genarel Setting Update Successfully', 'Success',);
        return back();

    }
//social Media
    public function socialMedia(){
        return view('admin.pages.settings.socialMedia');
    }
    public function socialMediaUpdate(SocialMediaSettingUpdateRequest $request){

        Setting::updateOrCreate([
            'key' => 'site_facebook_link',
            'value' => $request->site_facebook_link,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_twitter_link',
            'value' => $request->site_twitter_link,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_instragram_link',
            'value' => $request->site_instragram_link,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_behance_link',
            'value' => $request->site_behance_link,
        ]);
        Setting::updateOrCreate([
            'key' => 'site_dribbble_link',
            'value' => $request->site_dribbble_link,
        ]);


        Toastr::success('Social Media Update Successfully', 'Success',);
        return back();

    }
}
