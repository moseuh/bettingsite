<?php

namespace App\Http\Controllers\Admin;

use App\Deposit;
use App\Http\Controllers\Controller;
use App\Trx;
use App\User;
use Illuminate\Http\Request;

class PaymentLogController extends Controller
{
    public function approved(){
        $page_title = "Payment Complete";
        $deposits = Deposit::where('status',1)->latest()->with('user')->paginate(25);
        $empty_message = 'No pending deposits.';
        return view('admin.gateway.payment-log',compact('page_title','deposits','empty_message'));
    }

    public function pending()
    {
        $page_title = 'Pending Deposits';
        $empty_message = 'No pending deposits.';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 2)->with(['user'])->latest()->paginate(25);
        return view('admin.gateway.payment-log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Deposits';
        $empty_message = 'No rejected deposits.';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', -2)->with(['user'])->latest()->paginate(25);
        return view('admin.gateway.payment-log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function index(){
        $page_title = 'Deposit History';
        $empty_message = 'No deposit history available.';
        $deposits = Deposit::with(['user'])->where('status','!=',0)->latest()->paginate(25);
        return view('admin.gateway.payment-log', compact('page_title', 'empty_message', 'deposits'));
    }
    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', -2);
                break;
            case 'list':
                $page_title .= 'Deposits History Search';
                break;
        }
        $deposits = $deposits->paginate(25);
        $page_title .= ' - ' . $search;

        return view('admin.gateway.payment-log', compact('page_title', 'search', 'scope', 'empty_message', 'deposits'));
    }


    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->update(['status' => 1]);


        $user = User::find($deposit->user_id);
        $user->balance = getAmount($user->balance + $deposit->amount);
        $user->update();

        Trx::create([
            'user_id' => $deposit->user_id,
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'main_amo' => getAmount($user->balance),
            'type' => '+',
            'title' => 'Deposit Via ' . $deposit->gateway_currency()->name,
            'trx' => $deposit->trx
        ]);

        session()->flash('success', 'Deposit has been approved.');
        return back();
    }

    public function reject(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->update(['status' => -2]);


        session()->flash('success', 'Deposit has been rejected.');
        return back();

    }

}
