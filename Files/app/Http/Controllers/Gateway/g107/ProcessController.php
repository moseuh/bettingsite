<?php

namespace App\Http\Controllers\Gateway\g107;

use App\Deposit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use Auth;

class ProcessController extends Controller
{
    /*
     * PayStack Gateway
     */

    public static function process($deposit)
    {
        $paystackAcc = json_decode($deposit->gateway_currency()->parameter);


        $send['key'] = $paystackAcc->public_key;
        $send['email'] = Auth::user()->email;
        $send['amount'] = $deposit->final_amo * 100;
        $send['currency'] = $deposit->method_currency;
        $send['ref'] = $deposit->trx;
        $send['view'] = 'payment.g107';

        return json_encode($send);
    }



    public function ipn(Request $request)
    {
        $request->validate([
            'reference' => 'required',
            'paystack-trxref' => 'required',
        ]);

        $track = $request->reference;
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $paystackAcc = json_decode($data->gateway_currency()->parameter);
        $secret_key = $paystackAcc->secret_key;

        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $track;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $secret_key]);
        $r = curl_exec($ch);
        curl_close($ch);



        if ($r) {
            $result = json_decode($r, true);

            if ($result) {
                if ($result['data']) {
                    if ($result['data']['status'] == 'success') {

                        $am = $result['data']['amount'];
                        $sam = round($data->final_amo, 2) * 100;

                        if ($am == $sam && $result['data']['currency'] == $data->method_currency  && $data->status == '0') {
                            PaymentController::userDataUpdate($data->trx);

                            session()->flash('success', 'Payment Successful');
                        } else {
                            session()->flash('danger', 'Less Amount Paid. Please Contact With Admin');
                        }
                    } else {
                        session()->flash('danger',$result['data']['gateway_response']);
                    }
                } else {
                    session()->flash('danger',$result['message']);
                }
            } else {
                session()->flash('danger','Something went wrong while executing');
            }
        } else {
            session()->flash('danger','Something went wrong while executing');
        }


        return redirect()->route('payment');
    }
}
