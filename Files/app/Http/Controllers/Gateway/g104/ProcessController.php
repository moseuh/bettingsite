<?php

namespace App\Http\Controllers\Gateway\g104;

use App\Deposit;
use App\GeneralSettings;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Session;

class ProcessController extends Controller
{

    /*
     * Skrill Gateway
     */
    public static function process($deposit)
    {
        $basic =  GeneralSettings::first();
        $skrillAcc = json_decode($deposit->gateway_currency()->parameter);

        $val['pay_to_email'] = trim($skrillAcc->pay_to_email);
        $val['transaction_id'] = "$deposit->trx";

        $val['return_url'] = route('payment');
        $val['return_url_text'] = "Return $basic->sitename";
        $val['cancel_url'] = route('payment');
        $val['status_url'] = route('g104');
        $val['language'] = 'EN';
        $val['amount'] = round($deposit->final_amo,2);
        $val['currency'] = "$deposit->method_currency";
        $val['detail1_description'] = "$basic->sitename";
        $val['detail1_text'] = "Pay To $basic->sitename";
        $val['logo_url'] = asset('assets/images/logo/logo.png');

        $send['val'] = $val;
        $send['view'] = 'payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://www.moneybookers.com/app/payment.pl';

        return json_encode($send);
    }


    public function ipn()
    {
        $data = Deposit::where('trx', $_POST['transaction_id'])->orderBy('id', 'DESC')->first();
        $SkrillrAcc = json_decode($data->gateway_currency()->parameter);
        $concatFields = $_POST['merchant_id']
            . $_POST['transaction_id']
            . strtoupper(md5($SkrillrAcc->secret_key))
            . $_POST['mb_amount']
            . $_POST['mb_currency']
            . $_POST['status'];

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $SkrillrAcc->pay_to_email && $data->status = '0') {
            PaymentController::userDataUpdate($data->trx);
        }
    }
}
