<?php

namespace App\Http\Controllers\Gateway\g115;

use App\Deposit;
use App\GeneralSettings;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Mollie\Laravel\Facades\Mollie;

class ProcessController extends Controller
{

    /*
     * Paypal Gateway
     */
    public static function process($deposit)
    {
        $basic =  GeneralSettings::first();
        $mollieAcc = json_decode($deposit->gateway_currency()->parameter);


        config(['mollie.key' => trim($mollieAcc->api_key)]);
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => "$deposit->method_currency",
                'value' => ''.sprintf('%0.2f', round($deposit->final_amo,2)).'', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => "Payment To $basic->sitename Account",
            'redirectUrl' => route('g115'),
            'metadata' => [
                "order_id" => $deposit->trx,
            ],
        ]);


        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id',$payment->id);
        session()->put('deposit_id',$deposit->id);

        $send['redirect'] = true;
        $send['redirect_url'] = $payment->getCheckoutUrl();

        return json_encode($send);
    }
    public function ipn()
    {

        $deposit_id = session()->get('deposit_id');
        if($deposit_id ==  null){
            session()->flash('danger','Invalid Request.');
            return redirect()->route('site');
        }

        $deposit = Deposit::where('id',$deposit_id)->where('status',0)->first();


        $mollieAcc = json_decode($deposit->gateway_currency()->parameter);
        config(['mollie.key' => trim($mollieAcc->api_key)]);
        $payment = Mollie::api()->payments()->get(session()->get('payment_id'));
        if ($payment->status == "paid") {
            PaymentController::userDataUpdate($deposit->trx);
            session()->flash('success','Transaction was successful.');
        }else{
            session()->flash('danger','Invalid Request.');
        }

        session()->forget('deposit_id');
        session()->forget('payment_id');
        return redirect()->route('payment');
    }
}
