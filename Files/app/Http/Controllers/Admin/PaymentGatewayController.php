<?php

namespace App\Http\Controllers\Admin;

use App\GatewayCurrency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Image;
Use File;
class PaymentGatewayController extends Controller
{
    public function paymentMethod(){
        $data['page_title'] = "Payment Method";
        $data['gateways'] = GatewayCurrency::where('method_code','<',1000)->get();
        return view('admin.gateway.index',$data);
    }
    public function paymentMethodEdit($id){
        $gateway = GatewayCurrency::findOrFail($id);
        $page_title = $gateway->name;
        $gate_currency = json_decode($gateway->supported_currencies);
        return view('admin.gateway.edit',compact('gateway','page_title','gate_currency'));
    }

    public function paymentMethodUpdate(Request $request, $id){
        $gateway = GatewayCurrency::findOrFail($id);
        $rules =  [
            'currency' => 'required',
            'symbol' => 'required',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric',
            'percent_charge' => 'required|numeric',
            'fixed_charge' => 'required|numeric',
            'rate' => 'required|numeric',
        ];
        $parameter = [];
        $collection = collect($request);
        foreach($collection as $k => $v){
            foreach (json_decode($gateway->parameter) as $key => $cus) {
                if($k != $key) {
                    continue;
                }else{
                    $rules[$key] = 'required|max:191';
                    $parameter[$key] = $v;
                }
            }
        }
        $this->validate($request, $rules);

        $gateway->rate = $request->rate;
        $gateway->currency = $request->currency;
        $gateway->symbol = $request->symbol;
        $gateway->min_amount = $request->min_amount;
        $gateway->max_amount = $request->max_amount;
        $gateway->percent_charge = $request->percent_charge;
        $gateway->fixed_charge = $request->fixed_charge;
        $gateway->status = ($request->status == 'on') ? 1 : 0;
        $gateway->parameter = $parameter;

        if($request->hasFile('image')){
            File::delete('public/images/gateways/'.$gateway->image);
            $image = $request->file('image');
            $filename = strtolower(trim($gateway->name)).'_'.time().'.jpg';
            $location = 'public/images/gateways/' . $filename;
            Image::make($image)->resize(400,400)->save($location);
            $gateway->image = $filename;
        }
        $gateway->save();
        session()->flash('success','Update Successfully');
        return back();
    }
}
