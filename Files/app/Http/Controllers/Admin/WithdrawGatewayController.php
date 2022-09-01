<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WithdrawMethod;
use Illuminate\Http\Request;
use Validator;
use Image;
Use File;

class WithdrawGatewayController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Withdraw Method";
        $data['gateways'] = WithdrawMethod::all();
        return view('admin.withdraw.index', $data);
    }

    public function create()
    {
        $page_title = "Add Withdraw Method: ";
        return view('admin.withdraw.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'withdraw_min' => 'required|numeric',
            'withdraw_max' => 'required|numeric',
            'percent' => 'required|numeric',
            'fix' => 'required|numeric',
            'duration' => 'required|max:191'
        ];

        $this->validate($request, $rules);


        $gateway['name'] = $request->name;
        $gateway['withdraw_min'] = $request->withdraw_min;
        $gateway['withdraw_max'] = $request->withdraw_max;
        $gateway['percent'] = $request->percent;
        $gateway['fix'] = $request->fix;
        $gateway['duration'] = $request->duration;
        $gateway['status'] = ($request->status == 'on') ? 1 : 0;

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {

                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }
        $gateway['input_form'] = $input_form;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = str_slug($request->name) . '_' . time() . '.jpg';
            $location = 'public/images/withdraw/' . $filename;
            Image::make($image)->resize(400, 400)->save($location);
            $gateway['image'] = $filename;
        }

        WithdrawMethod::create($gateway);

        session()->flash('success', 'Store Successfully');
        return back();
    }


    public function edit($id)
    {
        $gateway = WithdrawMethod::findOrFail($id);
        $page_title = "Withdraw Method: " . $gateway->name;
        return view('admin.withdraw.edit', compact('gateway', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $gateway = WithdrawMethod::findOrFail($id);

        $rules = [
            'name' => 'required',
            'withdraw_min' => 'required|numeric',
            'withdraw_max' => 'required|numeric',
            'percent' => 'required|numeric',
            'fix' => 'required|numeric',
            'duration' => 'required|max:191'
        ];

        $this->validate($request, $rules);

        $gateway->name = $request->name;
        $gateway->withdraw_min = $request->withdraw_min;
        $gateway->withdraw_max = $request->withdraw_max;
        $gateway->percent = $request->percent;
        $gateway->fix = $request->fix;
        $gateway->duration = $request->duration;

        $gateway->status = ($request->status == 'on') ? 1 : 0;

        $input_form = [];

        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {

                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $gateway->input_form = $input_form;

        if ($request->hasFile('image')) {

            File::delete('public/images/withdraw/' . $gateway->image);
            $image = $request->file('image');
            $filename = $gateway->name . '_' . time() . '.jpg';
            $location = 'public/images/withdraw/' . $filename;
            Image::make($image)->resize(400, 400)->save($location);
            $gateway->image = $filename;

        }
        $gateway->save();

        session()->flash('success', 'Update Successfully');
        return back();
    }
}
