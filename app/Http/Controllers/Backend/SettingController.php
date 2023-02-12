<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helpers;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MailSettingUpdateRequest;
use App\Http\Requests\GeneralSettingUpdateRequest;
use App\Http\Requests\SocialMediaSettingUpdateRequest;

class SettingController extends Controller
{
    public function general(){
        return view('admin.pages.settings.general');
    }
    public function generalUpdate(GeneralSettingUpdateRequest $request){

        // dd($request->all());
        Setting::updateOrCreate(
            ['key' => 'site_title'],
            ['value' => $request->site_title,]
        );
        Setting::updateOrCreate(
            ['key' => 'site_address'],
            ['value' => $request->site_address,]
        );
        Setting::updateOrCreate(
           [ 'key' => 'site_email'],
            ['value' => $request->site_email],
        );
        Setting::updateOrCreate(
            ['key' => 'site_phone'],
            ['value' => $request->site_phone],
        );
        Setting::updateOrCreate(
            ['key' => 'site_description'],
            ['value' => $request->site_description],
        );
        //company logo
        if($request->hasFile('site_logo')){
            if(setting('site_logo') !=null){
                Helpers::delete('uploads/company/'.setting('site_logo'));
            }
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => Helpers::upload('uploads/company/','png', $request->file('site_logo'))]
            );
        }
        //company favicon
        if($request->hasFile('site_favicon')){
            if(setting('site_favicon') !=null){
                Helpers::delete('uploads/company/'.setting('site_favicon'));
            }
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => Helpers::upload('uploads/company/','png', $request->file('site_favicon'))]
            );
        }


        Toastr::success('Genarel Setting Update Successfully', 'Success',);
        return back();

    }

//social Media
    public function socialMedia(){
        return view('admin.pages.settings.socialMedia');
    }
    public function socialMediaUpdate(SocialMediaSettingUpdateRequest $request){

        Setting::updateOrCreate(
            ['key' => 'site_facebook_link'],
            ['value' => $request->site_facebook_link],
        );
        Setting::updateOrCreate(
            ['key' => 'site_twitter_link'],
            ['value' => $request->site_twitter_link],
        );
        Setting::updateOrCreate(
            ['key' => 'site_instragram_link'],
            ['value' => $request->site_instragram_link],
        );
        Setting::updateOrCreate(
            ['key' => 'site_behance_link'],
            ['value' => $request->site_behance_link],
        );
        Setting::updateOrCreate(
            ['key' => 'site_dribbble_link'],
            ['value' => $request->site_dribbble_link],
        );

        Toastr::success('Social Media Update Successfully', 'Success',);
        return back();

    }

    public function mailView()
    {
        // Gate::authorize('mail-setting-view');
        return view('admin.pages.settings.mail');
    }

    public function mailUpdate(MailSettingUpdateRequest $request)
    {
        // Gate::authorize('mail-setting-update');
        Setting::updateOrCreate(
            ['key' => 'mail_mailer'],
            ['value' => $request->mail_mailer],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_host'],
            ['value' => $request->mail_host],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_port'],
            ['value' => $request->mail_port],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_username'],
            ['value' => $request->mail_username],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_password'],
            ['value' => $request->mail_password],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_encryption'],
            ['value' => $request->mail_encryption],
        );
        Setting::updateOrCreate(
            ['key' => 'mail_from_address'],
            ['value' => $request->mail_from_address],
        );


        // update ENV file
        $this->setEnvValue('MAIL_MAILER', $request->mail_mailer);
        $this->setEnvValue('MAIL_HOST', $request->mail_host);
        $this->setEnvValue('MAIL_PORT', $request->mail_port);
        $this->setEnvValue('MAIL_USERNAME', $request->mail_username);
        $this->setEnvValue('MAIL_PASSWORD', $request->mail_password);
        $this->setEnvValue('MAIL_ENCRYPTION', $request->mail_encryption);
        $this->setEnvValue('MAIL_FROM_ADDRESS', $request->mail_from_address);

        Toastr::success('Setting Updated Successfully!!!','success');
        return back();
    }

    /**
 * @param string $key
 * @param string $value
 */
    protected function setEnvValue(string $key, string $value)
    {
        $path = app()->environmentFilePath();
        $env = file_get_contents($path);

        $old_value = env($key);

        if (!str_contains($env, $key.'=')) {
            $env .= sprintf("%s=%s\n", $key, $value);
        } else if ($old_value) {
            $env = str_replace(sprintf('%s=%s', $key, $old_value), sprintf('%s=%s', $key, $value), $env);
        } else {
            $env = str_replace(sprintf('%s=', $key), sprintf('%s=%s',$key, $value), $env);
        }

        file_put_contents($path, $env);
    }
}
