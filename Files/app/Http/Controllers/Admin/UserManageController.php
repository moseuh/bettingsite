<?php

namespace App\Http\Controllers\Admin;

use App\BetInvest;
use App\Deposit;
use App\Etemplate;
use App\GeneralSettings;
use App\Http\Controllers\Controller;
use App\MoneyTransfer;
use App\Trx;
use App\User;
use App\UserLogin;
use App\WithdrawLog;
use Illuminate\Http\Request;
use Auth;

class UserManageController extends Controller
{

    public function users(){
        $data['page_title'] = "User List";
        $data['users'] = User::latest()->paginate(10);
        return view('admin.users.index', $data);
    }

    public function userSearch(Request $request){
        $search =  trim($request->search);
        $data['page_title'] = "Search";
        $data['users'] = User::where('username', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('phone', 'like', '%' . $search . '%')
                                ->orWhere('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->paginate(10);
        return view('admin.users.index', $data,compact('search'));
    }

    public function singleUser($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = $user->username." Info";
        return view('admin.users.details', $data,compact('user'));
    }



    public function statupdate(Request $request, $id)
    {
        $user = User::findorFail($id);
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|alpha_num|max:255|unique:users,username,' . $user->id,
            'email' => 'required|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|min:8|unique:users,phone,' . $user->id,
        ]);
        $in = request()->except('_token', '_method','phone');
        $user['phone'] =  $request->phone;
        $user['status'] = $request->status;
        $user['email_verify'] = $request->email_verify == "1" ? 1 : 0;
        $user['phone_verify'] = $request->phone_verify == "1" ? 1 : 0;
        $user->fill($in)->save();
        session()->flash('success','Profile Updated Successfully');
        return back();
    }

    public function passwordSetting($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = $user->username." Password Setting";
        return view('admin.users.password', $data,compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findorFail($id);

        $request->validate([
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if ($password != $passwordConf) {
            session()->flash('danger', 'Password Do not match!!');

        } elseif ($password == $passwordConf) {
            $user->password = bcrypt($password);
            $user->save();
            session()->flash('success', 'Password Changed Successfully!!');
        }
        return back();
    }

    public function ManageBalanceByUsers($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = $user->username." Manage Balance";
        return view('admin.users.balance', $data,compact('user'));
    }



    public function saveBalanceByUsers(Request $request)
    {
        $basic = GeneralSettings::first();
        $gnl = GeneralSettings::first();

        $temp = Etemplate::first();
        $template = $temp->emessage;
        $from = $temp->esender;

        $user = User::findorFail($request->id);
        $this->validate($request, [
            'amount' => 'required|numeric',
            'message' => 'required'
        ]);

        if ($request->operation == "on") {
            $user->balance += $request->amount;
            $user->save();

            $txt = $request->amount . ' ' . $basic->currency . ' credited in your account.' . '<br>' . $request->message;
            notify($user, 'Credited Your Account', $txt);


            $message = $request->amount . ' ' . $basic->currency . ' credited to '  .$user->name.' By '.Auth::guard('admin')->user()->username;


            $headers = "From: $gnl->sitename <$from> \r\n";
            $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $mm = str_replace("[[name]]", 'Admin', $template);
            $msg = str_replace("[[message]]", $message, $mm);

            @mail($gnl->email, 'Added balance by Admin', $msg, $headers);

        } else {
            if ($user->balance > $request->amount) {
                $user->balance -= $request->amount;
                $user->save();


                $txt = $request->amount . ' ' . $basic->currency . ' debited in your account.' . '<br>' . $request->message;
                notify($user, 'Debited Your Account', $txt);


                $message = $request->amount . ' ' . $basic->currency . ' debited From '  .$user->name.' By '.Auth::guard('admin')->user()->username;

                $headers = "From: $gnl->sitename <$from> \r\n";
                $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $mm = str_replace("[[name]]", 'Admin', $template);
                $msg = str_replace("[[message]]", $message, $mm);
                @mail($gnl->email, 'Debited balance by Admin', $msg, $headers);

            } else {
                session()->flash('danger','Insufficient Balance To Subtract!');
                return back();
            }
        }

        session()->flash('success','Successfully Completed!');
        return back();
    }

    public function userEmail($id)
    {
        $user = User::findorFail($id);
        $data['page_title'] = $user->username." Send Email";
        return view('admin.users.send-email', $data,compact('user'));
    }
    public function sendEmail(Request $request)
    {

        $this->validate($request,
            [
                'emailto' => 'required|email',
                'receiver' => 'required',
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
        $to = $request->emailto;
        $name = $request->receiver;
        $subject = $request->subject;
        $message = $request->emailMessage;

        send_email($to, $name, $subject, $message);

        session()->flash('success', 'Mail Sent Successfully!');
        return back();
    }

    public function userSendSms($id)
    {
        $data['user'] = User::findorFail($id);
        $data['page_title'] = "Send SMS";
        return view('admin.users.send-sms', $data);
    }

    public function sendSmsToUser(Request $request)
    {
        $this->validate($request,[
                'phone' => 'required',
                'username' => 'required',
                'message' => 'required'
            ]);

        send_sms($request->phone, $request->message);
        session()->flash('success', 'SMS Sent Successfully!');
        return back();
    }

    public function predictions($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->username - All Prediction ";
        $logs = BetInvest::whereUser_id($user->id)->latest()->paginate(20);
        return view('admin.users.predictions', compact('logs', 'page_title','user'));
    }

    public function paymentLog($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->username -  Payment Log";
        $logs = Deposit::whereUser_id($id)->whereIn('status',[2,-2,1])->latest()->paginate(20);
        return view('admin.users.payment-log', compact('logs', 'page_title', 'user'));
    }
    public function withdrawLog($id)
    {
        $user = User::findorFail($id);
        $page_title = "$user->username -  withdraw Log";
        $logs = WithdrawLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->paginate(20);
        return view('admin.users.withdraw-log', compact('logs', 'page_title', 'user'));
    }

    public function transferSEND($id){
        $user = User::findorFail($id);
        $page_title = "$user->username - Money Transfer (Send)";

        $logs = MoneyTransfer::with('transferTo')->where('sender_id',$user->id)->latest()->paginate(20);
        return view('admin.users.transfer-send', compact('logs', 'page_title','user'));
    }

    public function transferRECEIVE($id){
        $user = User::findorFail($id);
        $page_title = "$user->username -  Money Transfer (Receive)";
        $logs = MoneyTransfer::with('transferForm')->where('receiver_id',$user->id)->latest()->paginate(20);
        return view('admin.users.transfer-receive', compact('logs', 'page_title', 'user'));
    }

    public function transactionLog($id){
        $user = User::findorFail($id);
        $page_title = "$user->username - All Transaction";

        $logs = Trx::whereUser_id($user->id)->latest()->paginate(20);
        return view('admin.users.transaction', compact('logs', 'page_title','user'));
    }

    public function loginLogs($id){

        $user = User::findorFail($id);
        $page_title = "$user->username - All Transaction";

        $logs = UserLogin::where('user_id', $user->id)->latest()->paginate(20);
        return view('admin.users.login-logs', compact('logs', 'page_title','user'));

    }



}
