<?php

namespace App\Http\Controllers\User;

use App\GeneralSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use App\User;
use DB;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $basic= GeneralSettings::first();

    }

    public function showLinkRequestForm()
    {
        $data['page_title'] = "Send Link password";
        return view('auth.passwords.email',$data);
    }

    public function showLinkRequestFormMobile()
    {
        $data['page_title'] = "Send Link password";
        return view('auth.passwords.mobile',$data);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $us = User::whereEmail($request->email)->count();
        if ($us == 0)
        {
            session()->flash('danger','We can\'t find a user with that e-mail address.');
            return back();
        }else{
            $user = User::whereEmail($request->email)->first();
            $to =$user->email;
            $name = $user->name;
            $subject = 'Password Reset';
            $code = getTrx(25);

            $link = url('/user-password/').'/reset/'.$code;

            $message = "Use This Link to Reset Password: <br>";
            $message .= "<a href='$link'>".$link."</a>";

            DB::table('password_resets')->insert(
                ['email' => $to, 'token' => $code,  'created_at' => date("Y-m-d h:i:s")]
            );
            send_email($to,  $name, $subject,$message);

            session()->flash('success','Password Reset Link Send Your E-mail');
            return back();
        }
    }





}
