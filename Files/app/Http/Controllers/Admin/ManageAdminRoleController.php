<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ManageAdminRoleController extends Controller
{
    protected $admin;

	public function __construct()
    {
    }
    
    public function staff()
    {
        $data['page_title'] = 'Manage Admin & Permission';
        $data['events'] = Admin::all();
        return view('admin.staff.index', $data);
        
    }

    public function storeStaff(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:191',
            'username' => 'required|alpha_dash|unique:admins,username',
            'email' => 'required|email|max:191|unique:admins,email',
            'password' => 'required|min:6',
            'status' => 'required'
        ]);

        $item = new Admin();
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->mobile = $request->mobile;
        if(isset($request->password)){
            $item->password = Hash::make($request->password);
        }

        $item->admin_access = (isset($request->access)) ? json_encode($request->access) : json_encode([]);
        $item->status = $request->status;
        $item->save();

      	session()->flash('success','Added Successfully');
        return back();
    }


    public function updateStaff(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|max:191',
            'username' => 'required|alpha_dash|unique:admins,username,'.$id,
            'email' => 'required|email|max:191|unique:admins,email,'.$id,
            'password' => 'nullable|min:6',
            'status' => 'required'
        ]);

        $item = Admin::findOrFail($id);
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->mobile = $request->mobile;
        if(isset($request->password)){
            $item->password = Hash::make($request->password);
        }


        $item->admin_access = (isset($request->access)) ? json_encode($request->access) : json_encode([]);
        $item->status = $request->status;
        $item->save();

        session()->flash('success','Updated Successfully');
        return back();

    }
}
