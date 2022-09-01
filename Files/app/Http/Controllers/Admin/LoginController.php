<?php

namespace App\Http\Controllers\Admin;


use App\AdminLogin;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return admin_authorize(Auth::guard('admin')->user()->access);
        }
        $data['page_title'] = "Admin Login";
        return view('admin.auth.login', $data);
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();
            $user->login_time = Carbon::now();
            $user->save();

            $info = json_decode(json_encode(getIpInfo()), true);
            $ul['user_id'] = $user->id;
            $ul['user_ip'] = request()->ip();
            $ul['long'] = @implode(',', $info['long']);
            $ul['lat'] = @implode(',', $info['lat']);
            $ul['location'] = @implode(',', $info['city']) . (" - " . @implode(',', $info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ");
            $ul['country_code'] = @implode(',', $info['code']);
            $ul['browser'] = $info['browser'];
            $ul['os'] = $info['os_platform'];
            $ul['country'] = @implode(',', $info['country']);

            AdminLogin::create($ul);
            return admin_authorize($user->access);
        } else {

            session()->flash('danger', 'Username and Password Not Matched');
            return redirect()->back();
        }
    }


}
