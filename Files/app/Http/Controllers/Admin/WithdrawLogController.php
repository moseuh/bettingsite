<?php

namespace App\Http\Controllers\Admin;

use App\GeneralSettings;
use App\Http\Controllers\Controller;
use App\Trx;
use App\User;
use App\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
class WithdrawLogController extends Controller
{
    public function request(){
        $data['page_title'] = "Withdraw Request";
        $data['logs'] = WithdrawLog::with('user','method')->where('status',1)->latest()->paginate(25);
        return view('admin.withdraw.withdraw-log',$data);
    }

    public function index(){
        $data['page_title'] = "Withdraw Log";
        $data['logs'] = WithdrawLog::with('user','method')->whereIn('status',[2,-2])->latest()->paginate(25);
        return view('admin.withdraw.withdraw-log',$data);
    }

    public  function action(Request $request, $id){

        $this->validate($request, [
            'id' => 'required',
            'status' => ['required',Rule::in(['2','-2'])],
        ]);

        $data = WithdrawLog::where('id', $request->id)->whereIn('status',[1])->firstOrFail();



        if($request->status == '2'){

            $data->status = 2;
            $data->admin_id =Auth::guard('admin')->id();;
            $data->save();

            session()->flash('success','Approve Successfully');

            return back();

        }elseif ($request->status == '-2'){

            $basic = GeneralSettings::first();
            $data->status = -2;
            $data->admin_id = Auth::guard('admin')->id();
            $data->save();

            $user = User::find($data['user_id']);
            $user->balance = round(($user->balance + $data->net_amount),2);
            $user->save();

            $tr = getTrx();
            Trx::create([
                'user_id' => $user->id,
                'amount' => $data->net_amount,
                'main_amo' => $user->balance,
                'charge' => 0,
                'type' => '+',
                'title' => 'Withdraw Amount Refunded' ,
                'trx' => $tr,
            ]);


            $msg =  "Your withdraw amount " . number_format($data->net_amount,2). ' '.$basic->currency . " refund  successfully. ";
            $msg .=  ' Your main balance ' .number_format($user->balance,2). ' '.$basic->currency;
            $msg .= "\n". date('d M Y  h:i A');
            notify($user,'Withdraw Amount Refunded', $msg);

            session()->flash('success','Reject Successfully');
            return back();
        }
    }
}
