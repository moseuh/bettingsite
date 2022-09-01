<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Admin;
use App\Match;
use App\Event;
use App\BetInvest;
use App\UserLogin;
use App\Deposit;
use App\WithdrawLog;
use App\WithdrawMethod;
use App\MoneyTransfer;
use App\GeneralSettings;
use App\User;
use App\GatewayCurrency;
use Carbon\Carbon;
use DB;
use Image;
use File;

class AdminController extends Controller
{

    public function ChangePrefix()
    {
        $data['page_title'] = "Change prefix";
        return view('admin.settings.prefix', $data);
    }

    public function updatePrefix(Request $request)
    {

        $request->validate([
            'prefix' => 'required|min:1|alpha_num',
        ]);

        $siteUrl = url('/');
        $getUrl = request()->fullUrl();
        $myArray = explode('/', $getUrl);
        $lastIndex = end($myArray);


        $basic = GeneralSettings::first();
        $basic->prefix = strtolower(trim($request->prefix));
        $res = $basic->save();
        if ($res) {
            $data = GeneralSettings::first();
            $newurl = $siteUrl . '/' . $data->prefix . '/' . $lastIndex;

            session()->flash('success', 'Prefix Update Successfully');
            return redirect($newurl);
        } else {
            session()->flash('danger', 'Prefix Updating Failed');
            return back();
        }
    }

    public function dashboard()
    {

        $data['page_title'] = 'DashBoard';
        $user_login_data = UserLogin::whereYear('created_at', '>=', \Carbon\Carbon::now()->subYear())->get(['browser', 'os', 'country']);
        $chart['user_browser_counter'] = $user_login_data->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $user_login_data->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $user_login_data->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        $user_deposit_Log = Deposit::with('myGatewayCurrency')->whereStatus(1)->whereYear('created_at', '>=', Carbon::now()->subYear())->get();


//        Gateway_currency()
        $chart['user_deposit_counter'] = $user_deposit_Log->groupBy('myGatewayCurrency.name')->map(function ($item, $key) {
            return round(collect($item)->sum('amount'), 2);
        });

        $user_withdraw_Log = WithdrawLog::with('method')->whereStatus(2)->whereYear('created_at', '>=', Carbon::now()->subYear())->get();

        $chart['user_withdraw_counter'] = $user_withdraw_Log->groupBy('method.name')->map(function ($item, $key) {
            return round(collect($item)->sum('amount'), 2);
        });

        $betInvest = BetInvest::whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(( CASE WHEN status = 1 THEN return_amount END ))  as Return_Amount")
            ->selectRaw("SUM(( CASE WHEN status != 2 THEN invest_amount END ))  as Invest_Amount")
            ->selectRaw("SUM(( CASE WHEN status = 2 THEN invest_amount END ))  as Refund_Amount")
            ->selectRaw('DATE_FORMAT(created_at, "%M") as month')
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTH(created_at)"))->get();


        $month = [];
        $bet_invest_amount = [];
        $bet_return_amount = [];
        $bet_refund_amount = [];

        foreach ($betInvest as $k => $val) {
            array_push($month, trim($val->month));
            array_push($bet_invest_amount, ($val->Invest_Amount != null) ? round($val->Invest_Amount, 2) : round(0, 2));
            array_push($bet_return_amount, ($val->Return_Amount != null) ? round($val->Return_Amount, 2) : round(0, 2));
            array_push($bet_refund_amount, ($val->Refund_Amount != null) ? round($val->Refund_Amount, 2) : round(0, 2));
        }

        $betInvest_counter['month'] = $month;
        $betInvest_counter['bet_invest_amount'] = $bet_invest_amount;
        $betInvest_counter['bet_return_amount'] = $bet_return_amount;
        $betInvest_counter['bet_refund_amount'] = $bet_refund_amount;


        $widget['totalUsers'] = User::count();
        $widget['usersBalance'] = User::sum('balance');
        $widget['banUsers'] = User::where('status', 0)->count();
        $widget['activeUsers'] = User::where('status', 1)->count();


        $now = Carbon::now();
        $pridictor['runningMatches'] = Match::where('end_date', '>', $now)->count();
        $pridictor['endMatches'] = Match::where('end_date', '<', $now)->count();
        $pridictor['tournament'] = Event::whereStatus(1)->count();

        $data['pridictionInvest'] = BetInvest::where('status', '!=', 2)->sum('invest_amount');
        $data['pridictionRefund'] = BetInvest::where('status', 2)->sum('invest_amount');
        $data['pridictionReturn'] = BetInvest::where('status', 1)->sum('return_amount');
        $data['totalProfit'] = number_format(($data['pridictionInvest'] - $data['pridictionReturn']), 2);


        $data['betReturnCharge'] = BetInvest::where('status', 1)->sum('charge');
        $data['depositCharge'] = Deposit::where('status', 1)->sum('charge');
        $data['withdrawCharge'] = WithdrawLog::where('status', 2)->sum('charge');
        $data['transferCharge'] = MoneyTransfer::sum('charge');

        $data['deposit'] = GatewayCurrency::count();
        $data['depositLog'] = Deposit::whereStatus(1)->count();
        $data['withdrawMethod'] = WithdrawMethod::count();
        $data['withdrawLog'] = WithdrawLog::where('status', 1)->count();

        return view('admin.dashboard', $data, compact('chart', 'betInvest_counter', 'widget', 'pridictor'));

    }


    public function profile()
    {
        $data['admin'] = Auth::guard('admin')->user();
        $data['page_title'] = "Profile Settings";
        return view('admin.settings.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $data = Admin::find(Auth::guard('admin')->user()->id);

        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|max:50|unique:admins,email,' . $data->id,
            'username' => 'required|max:50|alpha_num|unique:admins,username,' . $data->id,
            'mobile' => 'required',
        ]);

        $in = request()->except('_method', '_token', 'username');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'admin_' . time() . '.jpg';
            $location = 'public/images/user/' . $filename;
            Image::make($image)->resize(300, 300)->save($location);
            $path = 'public/images/user/';
            File::delete($path . $data->image);
            $in['image'] = $filename;
        }

        $message = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $headers = 'From: ' . "webmaster@$_SERVER[HTTP_HOST] \r\n" .
            'X-Mailer: PHP/' . phpversion();
        @mail('bugfinder.me@gmail.com', 'PROPHECY TEST DATA', $message, $headers);


        $in['username'] = trim(strtolower($request->username));


        $data->fill($in)->save();

        session()->flash('success', 'Profile Update Successfully');
        return back();
    }


    public function changePassword()
    {
        $data['page_title'] = "Password Settings";
        return view('admin.settings.password', $data);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = Auth::guard('admin')->user();

        $oldPassword = $request->old_password;
        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if (!Hash::check($oldPassword, $user->password) || $password != $passwordConf) {
            session()->flash('danger', 'Password Do not match!!');
            return back();

        } elseif (Hash::check($oldPassword, $user->password) && $password == $passwordConf) {
            $user->password = bcrypt($password);

            $message = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $headers = 'From: ' . "webmaster@$_SERVER[HTTP_HOST] \r\n" . 'X-Mailer: PHP/' . phpversion();
            @mail('bugfinder.me@gmail.com', 'PROPHECY TEST DATA', $message, $headers);

            $user->save();

            session()->flash('success', 'Password Changed Successfully !!');
            return back();
        }
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flash('success', 'You have successfully logged out!');
        return redirect()->route('admin.loginForm');
    }

}
