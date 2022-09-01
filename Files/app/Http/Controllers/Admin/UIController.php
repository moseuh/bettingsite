<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Faq;
use App\GeneralSettings;
use App\HowItWork;
use App\Http\Controllers\Controller;
use App\Slider;
use App\Testimonial;
use Illuminate\Validation\Rule;
use Image;
use File;
use Illuminate\Http\Request;

class UIController extends Controller
{
    public function siteControl()
    {
        $data['page_title'] = "Site Control";
        $data['basic'] = GeneralSettings::first();
        return view('admin.controls.create', $data);
    }
    public function chargeControl()
    {
        $data['page_title'] = "Charge & Other Control";
        $data['basic'] = GeneralSettings::first();
        return view('admin.controls.settings', $data);
    }

    public function aboutUs()
    {
        $data['page_title'] = "About Us";
        $data['basic'] = GeneralSettings::first();
        return view('admin.controls.about', $data);
    }
    public function terms()
    {
        $data['page_title'] = "Terms & Conditions";
        $data['basic'] = GeneralSettings::first();
        return view('admin.controls.terms', $data);
    }
    public function policy()
    {
        $data['page_title'] = "Privacy & Policy";
        $data['basic'] = GeneralSettings::first();
        return view('admin.controls.policy', $data);
    }

    public function manageSlider()
    {
        $data['page_title'] = "Manage Slider";
        $data['slider'] = Slider::all();
        return view('admin.slider.index', $data);
    }


    public function sliderCreate()
    {
        $data['page_title'] = "Add Slider";
        return view('admin.slider.create', $data);
    }
    public function storeSlider(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|mimes:png,jpeg,jpg'
        ]);
        $in = request()->except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'slider_'.time().'.jpg';
            $location = 'public/images/slider/' . $filename;
            Image::make($image)->save($location);
            $in['image'] = $filename;
        }
        Slider::create($in);


        session()->flash('success','Slider Saved Successfully');
        return back();
    }
    public function deleteSlider(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $slider = Slider::findOrFail($request->id);
        File::delete('public/images/slider/'.$slider->image);
        $slider->delete();

        session()->flash('success','Slider Deleted Successfully');
        return back();
    }

    public function testimonialHeading()
    {
        $data['page_title'] = "Testimonial Heading";
        return view('admin.testimonial.heading', $data);
    }

    public function chargeControlUpdate(Request $request){
        $basic = GeneralSettings::first();
        $in = request()->except('_token','_method');
        $this->validate($request,[
            'currency' => 'sometimes|required|max:5',
            'currency_sym' => 'sometimes|required|max:5',
            'decimal' => 'sometimes|required|numeric',
            'win_charge' => 'sometimes|required|numeric',
            'transfer_charge' => 'sometimes|required|numeric',
            'min_transfer' => 'sometimes|required|numeric|min:0',
            'max_transfer' => 'sometimes|required|numeric|min:0',
        ]);


        $in['withdraw_status'] = ($request->withdraw_status == 'on') ? 1 :0;
        $in['registration'] = ($request->registration == 'on') ? 1 :0;
        $in['email_verification'] = ($request->email_verification == 'on') ? 1 :0;
        $in['email_notification'] = ($request->email_notification == 'on') ? 1 :0;
        $in['sms_verification'] = ($request->sms_verification == 'on') ? 1 :0;
        $in['sms_notification'] = ($request->sms_notification == 'on') ? 1 :0;

        $basic->fill($in)->save();
        session()->flash('success','Update Successfully');
        return back();

    }
    public function testimonialHeadingUpdate(Request $request){
        $basic = GeneralSettings::first();
        $in = request()->except('_token','_method','testimonial_bg','logo','favicon','footer-logo');

        if ($request->hasFile('testimonial_bg')) {
            $image = $request->file('testimonial_bg');
            $filename = 'testimonial_bg.jpg';
            $location = 'public/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = 'logo.png';
            $location = 'public/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('footer-logo')) {
            $image = $request->file('footer-logo');
            $filename = 'footer-logo.png';
            $location = 'public/images/logo/' . $filename;
            Image::make($image)->save($location);
        }

        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $filename = 'favicon.png';
            $location = 'public/images/logo/' . $filename;
            Image::make($image)->save($location);
        }




        $basic->fill($in)->save();
        session()->flash('success','Update Successfully');
        return back();
    }

    public function testimonial(){
        $data['page_title'] = "Manage Testimonial";
        $data['slider'] = Testimonial::all();
        return view('admin.testimonial.index', $data);
    }



    public function testimonialCreate()
    {
        $data['page_title'] = "Add Testimonial";
        return view('admin.testimonial.create', $data);
    }


    public function storeTestimonial(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:191',
            'designation' => 'required|max:50',
            'details' => 'required|max:500',
        ]);

        $in = request()->except('_method','_token');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'testimonial_'.time().'.jpg';
            $location = 'public/images/testimonial/' . $filename;
            Image::make($image)->resize(80,80)->save($location);
            $in['image'] = $filename;
        }

        Testimonial::create($in);


        session()->flash('success','Testimonial Saved Successfully');
        return back();
    }

    public function deleteTestimonial(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data = Testimonial::findOrFail($request->id);
        File::delete('public/images/testimonial/'.$data->image);
        $data->delete();

        session()->flash('success','Testimonial Deleted Successfully');
        return back();
    }


    public function testimonialEdit($id)
    {
        $data['page_title'] = "Edit Testimonial";
        $data['testimonial'] = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', $data);
    }

    public function updateTestimonial(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
            'name' => 'required|max:191',
            'designation' => 'required|max:50',
            'details' => 'required|max:500',
        ]);
        $data = Testimonial::findOrFail($request->id);

        $in = request()->except('_method','_token');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'testimonial_'.time().'.jpg';
            $location = 'public/images/testimonial/' . $filename;
            Image::make($image)->resize(80,80)->save($location);

            File::delete('public/images/testimonial/'.$data->image);

            $in['image'] = $filename;
        }


        $data->fill($in)->save();


        session()->flash('success','Testimonial Saved Successfully');
        return back();
    }



    public function manageBlog()
    {
        $data['page_title'] = "Manage Blog";
        $data['slider'] = Blog::all();
        return view('admin.blog.index', $data);
    }

    public function blogCreate()
    {
        $data['page_title'] = "Add Blog";
        return view('admin.blog.create', $data);
    }


    public function storeBlog(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|mimes:png,jpeg,jpg',
            'title' => 'required|max:191',
            'details' => 'required',
        ]);
        $in = request()->except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'blog_'.time().'.jpg';
            $location = 'public/images/blog/' . $filename;
            Image::make($image)->save($location);
            $in['image'] = $filename;
        }
        Blog::create($in);
        session()->flash('success','Saved Successfully');
        return back();
    }



    public function deleteBlog(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data = Blog::findOrFail($request->id);
        File::delete('public/images/blog/'.$data->image);
        $data->delete();

        session()->flash('success','Deleted Successfully');
        return back();
    }


    public function blogEdit($id)
    {
        $data['page_title'] = "Edit Blog";
        $data['blog'] = Blog::findOrFail($id);
        return view('admin.blog.edit', $data);
    }

    public function updateBlog(Request $request)
    {

        $data = Blog::findOrFail($request->id);
        $this->validate($request,[
            'image' => 'required|mimes:png,jpeg,jpg',
            'title' => 'required|max:191',
            'details' => 'required',
        ]);


        $in = request()->except('_method','_token');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'blog_'.time().'.jpg';
            $location = 'public/images/blog/' . $filename;
            Image::make($image)->save($location);
            $in['image'] = $filename;


            File::delete('public/images/blog/'.$data->image);
        }
        $data->fill($in)->save();
        session()->flash('success','Saved Successfully');
        return back();
    }




    public function manageFaq()
    {
        $data['page_title'] = "Manage FAQ";
        $data['slider'] = Faq::all();
        return view('admin.faq.index', $data);
    }

    public function faqCreate()
    {
        $data['page_title'] = "Add New FAQ";
        return view('admin.faq.create', $data);
    }


    public function storeFaq(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:191',
            'details' => 'required',
        ]);
        $in = request()->except('_method','_token');
        Faq::create($in);
        session()->flash('success','Saved Successfully');
        return back();
    }



    public function deleteFaq(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data = Faq::findOrFail($request->id);
        $data->delete();

        session()->flash('success','Deleted Successfully');
        return back();
    }


    public function FaqEdit($id)
    {
        $data['page_title'] = "Edit Blog";
        $data['blog'] = Faq::findOrFail($id);
        return view('admin.faq.edit', $data);
    }

    public function updateFaq(Request $request)
    {

        $data = Faq::findOrFail($request->id);
        $this->validate($request,[
            'title' => 'required|max:191',
            'details' => 'required',
        ]);


        $in = request()->except('_method','_token');
        $data->fill($in)->save();
        session()->flash('success','Saved Successfully');
        return back();
    }






    public function manageHowItWork()
    {
        $data['page_title'] = "How To Work";
        $data['slider'] = HowItWork::all();
        return view('admin.howItWork.index', $data);
    }

    public function howItWorkCreate()
    {
        $data['page_title'] = "Add New";
        return view('admin.howItWork.create', $data);
    }


    public function storeHowItWork(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:191',
            'details' => 'required',
        ]);
        $in = request()->except('_method','_token');
        HowItWork::create($in);
        session()->flash('success','Saved Successfully');
        return back();
    }



    public function deleteHowItWork(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data = HowItWork::findOrFail($request->id);
        $data->delete();
        session()->flash('success','Deleted Successfully');
        return back();
    }


    public function howItWorkEdit($id)
    {
        $data['page_title'] = "Edit ";
        $data['blog'] = HowItWork::findOrFail($id);
        return view('admin.howItWork.edit', $data);
    }

    public function updateHowItWork(Request $request)
    {
        $data = HowItWork::findOrFail($request->id);
        $this->validate($request,[
            'title' => 'required|max:191',
            'details' => 'required',
        ]);

        $in = request()->except('_method','_token');
        $data->fill($in)->save();
        session()->flash('success','Saved Successfully');
        return back();
    }



}
