<?php

namespace App\Http\Controllers;

use App\BetInvest;
use App\BetOption;
use App\Deposit;
use App\GeneralSettings;
use App\Match;
use App\MoneyTransfer;
use App\Trx;
use App\User;
use App\WithdrawLog;
use App\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use File;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function authCheck()
    {
        if (Auth()->user()->status == '1' && Auth()->user()->email_verify == '1' && Auth()->user()->sms_verify == '1') {
            return redirect()->route('home');
        } else {
            $data['page_title'] = "Authentication";
            return view('user.authorization', $data);
        }
    }

    public function sendEmailCode(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Carbon::parse($user->email_time)->addMinutes(2) > Carbon::now()) {
            $time = Carbon::parse($user->email_time)->addMinutes(2);
            $delay = $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('danger', 'You can resend Verification Code after ' . $delay . ' minutes');
        } else {
            $code = mt_rand(100000, 999999);
            $user->email_time = Carbon::now();
            $user->verification_code = $code;
            $user->save();
            send_email($user->email, $user->username, 'Verification Code', 'Your Verification Code: ' . $code);

            session()->flash('success', 'Verification Code Send successfully');
        }
        return back();
    }

    public function postEmailVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->verification_code == $request->email_code) {
            $user->email_verify = 1;
            $user->verification_code = mt_rand(100000, 999999);
            $user->save();

            session()->flash('success', 'Your Profile has been verified successfully');
            return redirect()->route('home');
        } else {
            session()->flash('danger', 'Verification Code Did not matched.');
        }
        return back();
    }

    public function smsVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->sms_code == $request->sms_code) {
            $user->phone_verify = 1;
            $user->sms_code = mt_rand(100000, 999999);
            $user->save();

            session()->flash('success', 'Your Profile has been verified successfully');
            return redirect()->route('home');
        } else {
            session()->flash('danger', 'Verification Code Did not matched.');
        }
        return back();
    }

    public function sendVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (Carbon::parse($user->phone_time)->addMinutes(2) > Carbon::now()) {
            $time = Carbon::parse($user->phone_time)->addMinutes(2);
            $delay = $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('danger', 'You can resend Verification Code after ' . $delay . ' minutes');
            return back();

        } else {
            $code = mt_rand(100000, 999999);
            $user->phone_time = Carbon::now();
            $user->sms_code = $code;
            $user->save();
            send_sms($user->phone, 'Your Verification Code : ' . $code);

            session()->flash('success', 'Verification Code Send successfully');

        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['page_title'] = "My Prediction";
        $data['logs'] = BetInvest::with('match', 'user', 'ques', 'betoption')->whereUser_id(Auth::id())->latest()->paginate(20);
        return view('user.my-prediction', $data);
    }


    public function activity()
    {
        $user = Auth::user();
        $data['logs'] = Trx::whereUser_id($user->id)->latest()->paginate(20);
        $data['page_title'] = "Transaction Log";
        return view('user.transaction-log', $data);
    }


    public function depositLog()
    {
        $user = Auth::user();
        $data['logs'] = Deposit::with('user', 'myGatewayCurrency')->whereUser_id($user->id)->whereIn('status', [1, 2, -2])->latest()->paginate(20);
        $data['page_title'] = "Deposit Log";
        return view('user.deposit.log', $data);
    }

    public function changePassword()
    {
        $data['page_title'] = "Password Settings";
        return view('user.password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {

            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if (Hash::check($request->current_password, $c_password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                session()->flash('success', 'Password Changes Successfully.');
                return back();
            } else {
                session()->flash('danger', 'Current Password Not Match');
                return back();
            }

        } catch (\PDOException $e) {

            session()->flash('danger', $e->getMessage());
            return back();
        }
    }

    public function profileSetting()
    {
        $data['page_title'] = "Profile Settings";
        $data['user'] = User::findOrFail(Auth::id());
        return view('user.profile', $data);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'username' => 'required|min:5||alpha_num|unique:users,username,' . $user->id,
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'mimes:png,jpg,jpeg'
        ]);
        $in = request()->except('_method', '_token', 'balance');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'public/images/user/' . $filename;
            $in['image'] = $filename;
            $path = './public/images/user/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            Image::make($image)->resize(400, 400)->save($location);
        }
        $user->fill($in)->save();

        session()->flash('success', 'Profile Updated Successfully.');
        return back();
    }

    public function moneyTransfer()
    {
        $data['page_title'] = "Balance Transfer";
        return view('user.money-transfer', $data);
    }

    public function moneyTransferConfirm(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'amount' => 'required',
            'password' => 'required',
        ]);

        $basic = GeneralSettings::first();
        $email = trim($request->email);

        $receiver = User::where('email', $email)->first();


        if (!$receiver) {
            session()->flash('danger', 'This Email  could not Found!');
            return back()->withInput();
        }
        if ($receiver->id == Auth::id()) {
            session()->flash('danger', 'You could not Transfer in your account!');
            return back()->withInput();
        }

        if ($receiver->status == 0) {
            session()->flash('danger', 'Invalid User!');
            return back()->withInput();
        }


        if ($request->amount < $basic->min_transfer) {
            session()->flash('danger', 'Minimum Transfer Amount ' . $basic->min_transfer . ' ' . $basic->currency);
            return back()->withInput();
        }
        if ($request->amount > $basic->max_transfer) {
            session()->flash('danger', 'Maximum Transfer Amount ' . $basic->max_transfer . ' ' . $basic->currency);
            return back()->withInput();
        }


        $transferCharge = ($request->amount * $basic->transfer_charge) / 100;


        $user = User::find(Auth::id());
        if ($user->balance >= ($request->amount + $transferCharge)) {

            if (Hash::check($request->password, $user->password)) {


                $sendMoneyCheck = MoneyTransfer::where('sender_id', $user->id)->where('receiver_id', $receiver->id)->latest()->first();

                if (isset($sendMoneyCheck) && Carbon::parse($sendMoneyCheck->send_at) > Carbon::now()) {

                    $time = $sendMoneyCheck->send_at;
                    $delay = $time->diffInSeconds(Carbon::now());
                    $delay = gmdate('i:s', $delay);

                    session()->flash('danger', 'You can send money to this user after  delay ' . $delay . ' minutes');
                    return back()->withInput();
                } else {
                    $receiver->balance += round($request->amount, 2);
                    $receiver->save();

                    $user->balance = round(($user->balance - ($transferCharge + $request->amount)), 2);
                    $user->save();


                    $trans = getTrx();
                    $sendTaka = new MoneyTransfer();
                    $sendTaka->sender_id = $user->id;
                    $sendTaka->receiver_id = $receiver->id;
                    $sendTaka->amount = round($request->amount, 2);
                    $sendTaka->charge = $transferCharge;
                    $sendTaka->trx = $trans;
                    $sendTaka->send_at = Carbon::parse()->addMinutes(1);
                    $sendTaka->save();


                    $trx = Trx::create([
                        'user_id' => $user->id,
                        'amount' => round($request->amount, 2),
                        'main_amo' => $user->balance,
                        'charge' => $transferCharge,
                        'type' => '-',
                        'title' => 'Balance Transfer to  ' . $receiver->email,
                        'trx' => $trans,
                    ]);


                    $receiverRrx = Trx::create([
                        'user_id' => $receiver->id,
                        'amount' => round($request->amount, 2),
                        'main_amo' => $receiver->balance,
                        'charge' => 0,
                        'type' => '+',
                        'title' => 'Balance Transfer From  ' . $user->email,
                        'trx' => $trans,
                    ]);


                    $receiverMsg = round($request->amount, 2) . ' ' . $basic->currency . ' Balance Transfer From ' . $user->email . " \n Your main balance " . number_format($receiver->balance, 2) . " " . $basic->currency . ' #trx: ' . $receiverRrx->trx . "\n" . date('d M Y  h:i A');
                    notify($receiver, 'Balance Transfer', $receiverMsg);

                    $senderMsg = round($request->amount, 2) . ' ' . $basic->currency . ' Balance Transfer to ' . $receiver->email . " \n Your main balance " . number_format($user->balance, 2) . " " . $basic->currency . ' #trx: ' . $trx->trx . "\n" . date('d M Y  h:i A');

                    notify($user, 'Balance Transfer', $senderMsg);

                    session()->flash('success', 'Balance Transfer  has been Successful');
                    return redirect()->route('money-transfer');
                }
            } else {
                session()->flash('danger', 'Password Do Not Match');
                return back()->withInput();
            }
        } else {
            session()->flash('danger', 'Insufficient Balance');
            return back()->withInput();
        }
    }

    public function prediction(Request $request)
    {

        $basic = GeneralSettings::first();
        $this->validate($request, [
            'invest_amount' => 'required|numeric',
            'return_amount' => 'required|numeric'
        ]);

        $predictOption = BetOption::find($request->betoption_id);

        $user = User::find(Auth::id());
        $invseterBal = $user->balance;

        if (Carbon::parse($predictOption->question->end_time) > Carbon::now()) {
            if ($user->balance >= $request->invest_amount) {

                if ($predictOption->min_amo <= $request->invest_amount) {

                    $predictIn = BetInvest::where('user_id', Auth::id())->where('betoption_id', $predictOption->id)->where('betquestion_id', $predictOption->question->id)->where('match_id', $predictOption->match->id)->sum('invest_amount');
                    $lastPredictionIn = BetInvest::where('user_id', Auth::id())->where('betoption_id', $predictOption->id)->where('betquestion_id', $predictOption->question->id)->where('match_id', $predictOption->match->id)->latest()->first();

                    if ($lastPredictionIn && Carbon::parse($lastPredictionIn->created_at)->addSeconds(15) > Carbon::now()) {
                        $time = Carbon::parse($lastPredictionIn->created_at)->addSeconds(15);
                        $delay = $time->diffInSeconds(Carbon::now());
                        $delay = gmdate('i:s', $delay);
                        session()->flash('danger', 'You can next predict after ' . $delay . ' seconds in ' . $predictOption->option_name);
                        return back();
                    }

                    if (($predictIn + $request->invest_amount) > $predictOption->bet_limit) {
                        session()->flash('danger', "Your Prediction limit over in ( $predictOption->option_name)");
                        return back();
                    }


                    $data['user_id'] = Auth::id();
                    $data['betoption_id'] = $request->betoption_id;
                    $data['betquestion_id'] = $request->betquestion_id;
                    $data['match_id'] = $request->match_id;
                    $data['invest_amount'] = $request->invest_amount;

                    $finalRatioReturnAmo = round((($request->invest_amount * $predictOption->ratio2) / $predictOption->ratio1), 2);

                    $data['return_amount'] = $finalRatioReturnAmo;
                    $data['remaining_balance'] = $invseterBal;
                    $data['ratio'] = "$predictOption->ratio1 : $predictOption->ratio2";

                    $inverstInfo = BetInvest::create($data);
                    $trxQ = $inverstInfo->ques->question;

                    $user->balance -= round($request->invest_amount, 2);
                    $user->save();

                    $mm = Match::whereId($request->match_id)->first();
                    $tr = getTrx();
                    Trx::create([
                        'user_id' => $user->id,
                        'amount' => round($request->invest_amount, 2),
                        'main_amo' => $user->balance,
                        'charge' => 0,
                        'type' => '-',
                        'title' => 'Predict in ' . $mm->name . "<strong> ( " . $trxQ . "  =>   $predictOption->option_name )</strong>",
                        'trx' => $tr
                    ]);

                    session()->flash('success', 'Successfully Prediction in ' . $predictOption->option_name);
                    return back()->withInput();
                } else {
                    session()->flash('danger', "Minimum Prediction Amount $predictOption->min_amo $basic->currency");
                    return back()->withInput();
                }
            } else {
                session()->flash('danger', 'Insufficient Balance');
                return back()->withInput();
            }
        } else {
            session()->flash('danger', 'Time has been expired');
            return back()->withInput();
        }
    }



    public function withdrawLog()
    {
        $user = Auth::user();
        $data['logs'] = WithdrawLog::with('user', 'method')->whereUser_id($user->id)->where('status', '!=', 0)->latest()->paginate(20);
        $data['page_title'] = "Withdraw Log";
        return view('user.withdraw.log', $data);
    }

    public function withdrawMoney()
    {
        $data['page_title'] = "Withdraw Money";
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        return view('user.withdraw.money', $data);
    }


    public function withdrawMoneyRequest(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'amount' => ['required','numeric']
        ]);

        $basic = GeneralSettings::first();
        $method = WithdrawMethod::where('id', $request->id)->where('status', 1)->firstOrFail();

        $authWallet = User::find(Auth::id());


        $charge = $method->fix + ($request->amount * $method->percent / 100);

        $finalAmo = $request->amount + $charge;

        if ($request->amount < $method->withdraw_min) {
            session()->flash('danger', 'Minimum Withdraw Amount ' . round($method->withdraw_min, 2) . ' ' . $basic->currency);
            return back();
        }
        if ($request->amount > $method->withdraw_max) {
            session()->flash('danger', 'Maximum Withdraw Amount ' . round($method->withdraw_max, 2 ). ' ' . $basic->currency);
            return back();
        }

        if (formatter_money($finalAmo) > $authWallet->balance) {
            session()->flash('danger', 'Insufficient Balance For Withdraw.');
            return back();
        } else {

            $w['method_id'] = $method->id;
            $w['user_id'] = Auth::id();
            $w['amount'] = formatter_money($request->amount);
            $w['charge'] = $charge;
            $w['net_amount'] = $finalAmo;

            $w['transaction_id'] = getTrx();
            $w['status'] = 0;
            $result = WithdrawLog::create($w);


            session()->put('wtrx', $result->transaction_id);
            return redirect()->route('user.withdraw.preview');
        }
    }


    public function withdrawReqPreview()
    {

        $withdraw = WithdrawLog::with('method', 'user')->where('transaction_id', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $page_title = "Withdraw Form";
        return view('user.withdraw.preview', compact('withdraw', 'page_title'));
    }


    public function withdrawReqSubmit(Request $request)
    {
        $basic = GeneralSettings::first();
        $withdraw = WithdrawLog::with('method', 'user')->where('transaction_id', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();


        $rules = [];
        $inputField = [];
        if ($withdraw->method->input_form != null) {
            foreach ($withdraw->method->input_form as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = User::find(Auth::id());

        if (formatter_money($withdraw->net_amount) > $user->balance) {
            session()->flash('danger', 'Insufficient Balance For Withdraw.');
            return redirect()->route('user.withdraw-money');
        } else {
            $collection = collect($request);
            $reqField = [];
            if ($withdraw->method->input_form != null) {
                foreach ($collection as $k => $v) {
                    foreach ($withdraw->method->input_form as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {
                                    $image = $request->file($inKey);

                                    $filename = time() . uniqid() . '.jpg';
                                    $location = 'public/images/' . $filename;
                                    $reqField[$inKey] = [
                                        'field_name' => $filename,
                                        'type' => $inVal->type,
                                    ];
                                    Image::make($image)->save($location);
                                }
                            } else {
                                $reqField[$inKey] = $v;
                                $reqField[$inKey] = [
                                    'field_name' => $v,
                                    'type' => $inVal->type,
                                ];
                            }
                        }
                    }
                }
                $withdraw['withdraw_information'] = $reqField;
            } else {
                $withdraw['withdraw_information'] = null;
            }


            $withdraw->status = 1;
            $withdraw->save();


            $user->balance = formatter_money($user->balance - $withdraw->net_amount);
            $user->save();


             Trx::create([
                'user_id' => $user->id,
                'amount' => formatter_money($withdraw->amount),
                'main_amo' => $user->balance,
                'charge' => formatter_money($withdraw->charge),
                'type' => '-',
                'title' => 'Withdraw Via ' . $withdraw->method->name,
                'trx' => $withdraw->transaction_id
            ]);

            $text = number_format($withdraw->amount) . " " . $basic->currency . " Withdraw Request Send via " . $withdraw->method->name . ". <br> Transaction ID : <b>#$withdraw->transaction_id</b>";
            $text .= " Your main balance " . number_format($user->balance, 2) . " " . $basic->currency . "\n" . date('d M Y  h:i A');
            notify($user, 'Withdraw Via ' . $withdraw->method->name, $text);

            session()->flash('success','Withdraw request Successfully Submitted. Wait For Confirmation.');
            return redirect()->route('user.withdraw-money');

        }







    }


}
