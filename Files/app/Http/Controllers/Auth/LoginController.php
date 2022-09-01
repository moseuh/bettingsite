<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        $data['page_title'] = "Sign In";
        return view('auth.login',$data);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);


        $res =  $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());


        return $res;
    }



    protected function authenticated(Request $request, $user)
    {
        if ($user->status == 0) {
            $this->guard()->logout();
            session()->flash('danger', 'Your account has been deactivated.');
            return redirect()->route('login');
        }

        $info = json_decode(json_encode(getIpInfo()), true);
        $ul['user_id'] = $user->id;
        $ul['user_ip'] =  request()->ip();
        $ul['long'] =  @implode(',',$info['long']);
        $ul['lat'] =  @implode(',',$info['lat']);
        $ul['location'] =  @implode(',',$info['city']) . (" - ". @implode(',',$info['area']) ."- ") . @implode(',',$info['country']) . (" - ". @implode(',',$info['code']) . " ");
        $ul['country_code'] = @implode(',',$info['code']);
        $ul['browser'] = $info['browser'];
        $ul['os'] = $info['os_platform'];
        $ul['country'] =  @implode(',', $info['country']);
        UserLogin::create($ul);

        return redirect()->intended(route('home'));
    }


    public function logout(Request $request)
    {
        Auth::guard()->logout();

        session()->flash('success', 'You have been successfully logged out!!');
        return redirect(route('login'));
    }

}
