<?php

namespace App\Http\Controllers\Gateway\g101;

use App\Deposit;
use App\GeneralSettings;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;

class ProcessController extends Controller
{

    /*
     * Paypal Gateway
     */
    public static function process($deposit)
    {
        $basic =  GeneralSettings::first();
        $paypalAcc = json_decode($deposit->gateway_currency()->parameter);

        $val['cmd'] = '_xclick';
        $val['business'] = trim($paypalAcc->paypal_email);
        $val['cbt'] = $basic->sitename;
        $val['currency_code'] = "$deposit->method_currency";
        $val['quantity'] = 1;
        $val['item_name'] = "Payment To $basic->sitename Account";
        $val['custom'] = "$deposit->trx";
        $val['amount'] = round($deposit->final_amo,2);
        $val['return'] = route('payment');
        $val['cancel_return'] = route('payment');
        $val['notify_url'] = route('g101');
        $send['val'] = $val;
        $send['view'] = 'payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://secure.paypal.com/cgi-bin/webscr';
        return json_encode($send);
    }
    public function ipn()
    {
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // $paypalURL = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
        $paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
        $callUrl = $paypalURL . $req;
        $verify = curlContent($callUrl);
        if ($verify == "VERIFIED") {
            //PAYPAL VERIFIED THE PAYMENT
            $receiver_email = $_POST['receiver_email'];
            $mc_currency = $_POST['mc_currency'];
            $mc_gross = $_POST['mc_gross'];
            $track = $_POST['custom'];

            //GRAB DATA FROM DATABASE!!
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

            $paypalAcc = json_decode($data->gateway_currency()->parameter, true);

            $amount = round($data->final_amo,2);

            if ($receiver_email == $paypalAcc['paypal_email'] && $mc_currency == $data->method_currency && $mc_gross == $amount && $data->status == '0') {
                //Update User Data
                PaymentController::userDataUpdate($data->trx);
            }
        }
    }
}
