<?php

namespace App\Http\Controllers\Gateway\g102;

use App\Deposit;
use App\GeneralSettings;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use Auth;

class ProcessController extends Controller
{

    /*
     * Perfect Money Gateway
     */
    public static function process($deposit)
    {
        $basic =  GeneralSettings::first();
        $perfectAcc = json_decode($deposit->gateway_currency()->parameter);
        $val['PAYEE_ACCOUNT'] = trim($perfectAcc->wallet_id);;
        $val['PAYEE_NAME'] = $basic->sitename;
        $val['PAYMENT_ID'] = "$deposit->trx";
        $val['PAYMENT_AMOUNT'] = round($deposit->final_amo,2);
        $val['PAYMENT_UNITS'] = "$deposit->method_currency";

        $val['STATUS_URL'] = route('g102');
        $val['PAYMENT_URL'] = route('payment');
        $val['PAYMENT_URL_METHOD'] = 'POST';
        $val['NOPAYMENT_URL'] = route('payment');
        $val['NOPAYMENT_URL_METHOD'] = 'POST';
        $val['SUGGESTED_MEMO'] = Auth::user()->username;
        $val['BAGGAGE_FIELDS'] = 'IDENT';


        $send['val'] = $val;
        $send['view'] = 'payment.redirect';
        $send['method'] = 'post';
        $send['url'] = 'https://perfectmoney.is/api/step1.asp';

        return json_encode($send);
    }
    public function ipn()
    {

        $data = Deposit::where('trx', $_POST['PAYMENT_ID'])->orderBy('id', 'DESC')->first();
        $pmAcc = json_decode($data->gateway_currency()->parameter);
        $passphrase = strtoupper(md5($pmAcc->passphrase));

        define('ALTERNATE_PHRASE_HASH', $passphrase);
        define('PATH_TO_LOG', '/somewhere/out/of/document_root/');
        $string =
            $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' .
            $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' .
            $_POST['PAYMENT_BATCH_NUM'] . ':' .
            $_POST['PAYER_ACCOUNT'] . ':' . ALTERNATE_PHRASE_HASH . ':' .
            $_POST['TIMESTAMPGMT'];

        $hash = strtoupper(md5($string));
        $hash2 = $_POST['V2_HASH'];

        if ($hash == $hash2) {

            $amo = $_POST['PAYMENT_AMOUNT'];
            $unit = $_POST['PAYMENT_UNITS'];
            $track = $_POST['PAYMENT_ID'];
            if ($_POST['PAYEE_ACCOUNT'] == $pmAcc->wallet_id && $unit == $data->method_currency && $amo == $data->final_amo && $data->status == '0') {
                //Update User Data
                PaymentController::userDataUpdate($data->trx);
            }
        }
    }
}
