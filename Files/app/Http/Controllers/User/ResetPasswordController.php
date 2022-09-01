<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\GeneralSettings;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use DB;
use App\PasswordReset;
use Validator;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function showResetForm(Request $request, $token)
    {
        $data['page_title'] = "Change Password";
        $tk = PasswordReset::where('token', $token)->first();

        if (is_null($tk)) {
            session()->flash('danger','Token Not Found!');
            return redirect()->route('user.password.request');
        } else {

            $email = $tk->email;

            return view('auth.passwords.reset', $data)->with(
                ['token' => $token, 'email' => $email]
            );
        }
    }


    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $tk = PasswordReset::where('token', $request->token)->first();
        $user = User::whereEmail($tk->email)->first();
        if (!$user) {
            session()->flash('danger','Email don\'t match!');
            return back();
        }
        $user->password = bcrypt($request->password);
        $user->save();


        session()->flash('success','Successfully Password Reset.');

        return redirect()->route('login');
    }


    public function resetByMobile(Request $request)
    {

        $inputToken = $request->inputToken;
        $inputPhone = $request->inputPhone;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        $tk = User::where('sms_code_token', $inputToken)->first();
        $user = User::where('phone',$inputPhone)->first();
        if (!$user) {
            return response()->json(['status' => 'InvalidUser','msg' => 'Invalid User!!!']);
        }
        if($password != $password_confirmation){
            return response()->json(['status' => 'InvalidPass','msg' => 'Password  don\'t match!!']);            
        }

        $rules = array('password' => 'required|min:6');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json(['status' => 'InvalidLen','msg' => 'Password length must be 6 digit']);
        }

        $user->password = bcrypt($request->password);
        $user->sms_code_token = null;
        $user->sms_code = null;
        $user->save();

        return response()->json(['status' => 'success','msg' => 'Successfully Password Reset.',]);  

    }

    public function showResetFormMobile(Request $request, $token)
    {

        $data['page_title'] = "Enter SMS Code";
        $tk = User::where('sms_code_token', $token)->first();

        if (is_null($tk)) {
            $notification = array('message' => 'Token Not Found!!', 'alert-type' => 'warning');
            return redirect()->route('user.password.mobile')->with($notification);
        }

        $phone = $tk->phone;

        return view('auth.passwords.setcode', $data)->with(
            ['token' => $token, 'phone' => $phone]
        );
    }



    public function showResetFormMobileCode(Request $request)
    {
        $data['page_title'] = "Change Password";
        $tk = User::where('sms_code_token', $request->token)->first();

        if (is_null($tk)) {
            $notification = array('message' => 'Token Not Found!!', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        } else {
            if($tk->sms_code != $request->sms_code){
                $notification = array('message' => 'Invalid Code!!', 'alert-type' => 'error');
                return redirect()->back()->with($notification);
            }
            $user = User::where('phone', $request->phone)->where('sms_code',$request->sms_code)->first();

            $phone = $user->phone;
            $token = $user->sms_code_token;

            return view('auth.passwords.passReset', $data)->with(
                ['token' => $token, 'phone' => $phone]
            );
        }
    }
}
