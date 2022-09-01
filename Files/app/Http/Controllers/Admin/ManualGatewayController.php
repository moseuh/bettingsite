<?php

namespace App\Http\Controllers\Admin;

use App\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManualGatewayController extends Controller
{
    public function index()
    {
        $page_title = 'Manual Deposit Methods';

        $gateways = GatewayCurrency::manual()->latest()->get();

        $empty_message = 'No deposit methods available.';
        return view('admin.gateway_manual.list', compact('page_title', 'gateways','empty_message'));
    }

    public function create()
    {
        $page_title = 'New Manual Deposit Method';
        return view('admin.gateway_manual.create', compact('page_title'));
    }


    public function store(Request $request)
    {

        $validation_rule = [
            'name'           => 'required|max: 60',
            'image'          => [
                'nullable',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])
            ],
            'rate'           => 'required|gt:0',
            'delay'          => 'required',
            'currency'       => 'required',
            'min_amount'      => 'required|gt:0',
            'max_amount'      => 'required|gte:0',
            'fixed_charge'   => 'required|gte:0',
            'percent_charge' => 'required|between:0,100',
            'instruction'    => 'required|max:64000',
        ];

        $request->validate($validation_rule);
        $last_method = GatewayCurrency::manual()->orderBy('method_code','desc')->first();

        $method_code = 1000;
        if ($last_method) {
            $method_code = $last_method->method_code + 1;
        }

        $filename = '';
        $path = imagePath()['gateway']['path'];
        $size = imagePath()['gateway']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                session()->flash('danger','Image could not be uploaded.');
                return back();
            }
        }


        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $gate = GatewayCurrency::create([
            'currency' => $request->currency,
            'symbol' => $request->currency,
            'method_code' => $method_code,
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'rate' => $request->rate,
            'alias' => strtolower(trim(str_replace(' ','_',$request->name))),
            'image' => $filename,
            'status' => 0,
            'parameter' => json_encode($input_form),
            'extra' => ['delay' => $request->delay],
            'input_form' => $input_form,
            'supported_currencies' => json_encode([]),
            'description' => $request->instruction,
        ]);

        session()->flash('success','Manual Gateway has been added.');

        return redirect()->route('admin.deposit.manual.edit',[$gate->alias]);
    }

    public function edit($alias)
    {
        $page_title = 'New Manual Deposit Method';
        $method = GatewayCurrency::where('alias', $alias)->firstOrFail();
        return view('admin.gateway_manual.edit', compact('page_title', 'method'));
    }

    public function update(Request $request, $code)
    {
        $validation_rule = [
            'name'           => 'required|max: 60',
            'rate'           => 'required|gt:0',
            'image'          => [
                'nullable',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])
            ],
            'delay'          => 'required',
            'currency'       => 'required',
            'min_amount'      => 'required|gt:0',
            'max_amount'      => 'required|gte:0',
            'fixed_charge'   => 'required|gte:0',
            'percent_charge' => 'required|between:0,100',
            'instruction'    => 'required|max:64000'
        ];




        $request->validate($validation_rule);


        $method = GatewayCurrency::where('method_code', $code)->firstOrFail();


        $filename = $method->image;

        $path = imagePath()['gateway']['path'];
        $size = imagePath()['gateway']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                session()->flash('danger','Image could not be uploaded.');
                return back();
            }
        }

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }


        $method->update([
            'currency' => $request->currency,
            'symbol' => $request->symbol,
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'rate' => $request->rate,
            'alias' => strtolower(trim(str_replace(' ','_',$request->name))),
            'image' => $filename,
            'parameter' => json_encode($input_form),
            'extra' => ['delay' => $request->delay],
            'supported_currencies' => json_encode([]),
            'description' => $request->instruction,
            'input_form' => $input_form,
        ]);



        session()->flash('success',$method->name . ' Manual Gateway has been updated.');
        return redirect()->route('admin.deposit.manual.edit',[$method->alias]);
    }

    public function activate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = GatewayCurrency::where('method_code', $request->code)->first();
        $method->update(['status' => 1]);

        session()->flash('success',$method->name . ' has been activated.');
        return back();
    }

    public function deactivate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = GatewayCurrency::where('method_code', $request->code)->first();
        $method->update(['status' => 0]);


        session()->flash('success',$method->name . ' has been deactivated.');
        return back();
    }
}
