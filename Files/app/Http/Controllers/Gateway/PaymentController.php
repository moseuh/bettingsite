<?php

namespace App\Http\Controllers\Gateway;

use App\GeneralSettings;
use App\Trx;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GatewayCurrency;
use App\Deposit;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Gateway;
use App\Rules\FileTypeValidate;
use Validator;

class PaymentController extends Controller
{
    public function payment()
    {
        $gatewayCurrency = GatewayCurrency::orderby('method_code')->where('status',1)->get();
        $page_title = 'Payment Methods';
        return view( 'user.deposit.money', compact('gatewayCurrency', 'page_title'));
    }

    public function paymentRequest(Request $request){

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'gateway_id' => 'required|numeric',
        ],[
            'gateway_id.required'=>'Please Select a Payment Gateway'
        ]);

        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()]);
        }

        $general = GeneralSettings::first();

        $gate = GatewayCurrency::where('id', $request->gateway_id)->first();
        if (!$gate) {
            return response(['errors'=>['Invalid Payment Method']]);
        }


        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            return response(['errors'=>['Please Follow Deposit Limit']]);
        }


        $charge = formatter_money($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));

        $payable = formatter_money($request->amount + $charge);

        $final_amo = formatter_money($payable /$gate->rate);

        $depo['user_id'] = Auth::id();
        $depo['method_code'] = $gate->method_code;
        $depo['method_currency'] = strtoupper($gate->currency);
        $depo['amount'] = $request->amount;
        $depo['charge'] = $charge;
        $depo['rate'] = $gate->rate;
        $depo['final_amo'] = formatter_money($final_amo);
        $depo['btc_amo'] = 0;
        $depo['btc_wallet'] = "";
        $depo['trx'] = getTrx();
        $depo['try'] = 0;
        $depo['status'] = 0;

        $data = Deposit::create($depo);

        Session::put('Track', $data['trx']);

        $result['success'] = true;
        $result['logs'] = [
            'method' => $data->gateway_currency()->name,
            'amount' => ' Amount: ' .formatter_money($data->amount) . ' '. $general->currency_sym,
            'conversion_rate' => 'Rate: '. formatter_money($data->rate) .' '. $data->method_currency,
            'in' => 'In ' .$data->method_currency . ' '. formatter_money($data->amount/$data->rate),
            'charge' => 'Charge: ' .formatter_money($data->charge). ' '. $general->currency ,
            'payable' => 'Payable: ' .formatter_money($data->final_amo). ' '. $data->method_currency ,
            'method_code' => $data->method_code
        ];

        return response($result);
    }



    public function payNow()
    {
        $track = Session::get('Track');

        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if (is_null($deposit)) {
            session()->flash('danger','Invalid Payment Request');
            return redirect()->route('payment');
        }
        if ($deposit->status != 0) {
            session()->flash('danger','Invalid Payment Request');
            return redirect()->route('payment');
        }


        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);

            session()->flash('danger','Your deposit request is queued for approval.');
            return redirect()->route('payment');
        }

        $xx = 'g' . $deposit->method_code;
        $new =  __NAMESPACE__ . '\\' . $xx . '\\ProcessController';

        $data =  $new::process($deposit);
        $data =  json_decode($data);


        if (isset($data->error)) {
            session()->flash('danger',$data->message);
            return redirect()->route('payment');
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }
        $page_title = 'Payment Confirm';
        return view( $data->view, compact('data', 'page_title','deposit'));
    }


    public static  function userDataUpdate($trx)
    {
        $gnl = GeneralSettings::first();
        $data = Deposit::latest()->where('trx', $trx)->first();
        if ($data->status == 0) {
            $data['status'] = 1;
            $data->update();

            $user = User::find($data->user_id);

            $user->balance = round(($user->balance+$data->amount),$gnl->decimal) ;
            $user->save();

            $gateway = $data->gateway_currency();

            Trx::create([
                'user_id' => $user->id,
                'amount' => formatter_money($data->amount,$gnl->decimal),
                'main_amo' => formatter_money($user->balance, $gnl->decimal),
                'charge' => formatter_money($data->charge, $gnl->decimal),
                'type' => '+',
                'title' => 'Deposit Via ' . $gateway->name,
                'trx' => $data->trx
            ]);

            $txt = formatter_money($data->amount) . ' ' . $gnl->currency . ' Deposited Successfully Via ' . $gateway->name;
            notify($user, 'Deposit Successful', $txt);
        }
    }


    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('payment');
        }
        if ($data->status != 0) {
            return redirect()->route('payment');
        }
        if ($data->method_code > 999) {

            $page_title = 'Confirm Deposit';
            $method = $data->gateway_currency();
            return view('user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::where('status', 0)->where('trx', $track)->first();

        if (!$data) {
            return redirect()->route('payment');
        }
        if ($data->status != 0) {
            return redirect()->route('payment');
        }

        $params = json_decode($data->gateway_currency()->parameter);
        $rules = [];
        $inputField = [];

        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                    array_push($verifyImages, $key);
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
        $path = imagePath()['deposit']['path'];
        $collection = collect($request);

        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    session()->flash('danger', 'Could not upload your ' . $inKey);
                                    return back()->withInput();
                                }
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
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }



        $data->status = 2; // pending
        $data->update();

        session()->flash('success', 'You have deposit request has been taken.');
        return redirect()->route('depositLog');
    }

}
