<?php

namespace App\Http\Controllers;

use App\BetInvest;
use App\BetQuestion;
use App\Blog;
use App\Deposit;
use App\Event;
use App\Faq;
use App\GatewayCurrency;
use App\HowItWork;
use App\Match;
use App\Slider;
use App\Testimonial;
use App\User;
use App\WithdrawMethod;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteController extends Controller
{
    public function index(){
        $now = Carbon::now();
        $data['page_title'] = "Home";
        $data['sliders'] = Slider::latest()->get();
        $data['matches'] = Match::with('event')->whereStatus(1)->where('status', '!=' ,2)->where('end_date','>', $now)->orderBy('start_date','asc')->limit(10)->get();

        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();
        $data['gateway'] = GatewayCurrency::where('status',1)->get();
        $data['withdraw'] = WithdrawMethod::where('status',1)->count();

        $data['howItWork'] = HowItWork::get();
        $data['testimonials'] = Testimonial::latest()->get();
        $data['blogs'] = Blog::orderBy('id','desc')->limit(4)->get();

        $date = Carbon::today()->subDays(7);

        $weeklyLeader = BetInvest::with('user')->where('created_at', '>=', $date)->where('status','!=',2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->limit(5)
            ->orderBy('investAmount','desc')
            ->get();

        $leader = BetInvest::with('user')->where('status','!=',2)->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as total_predictions'),  DB::raw('sum(invest_amount) as investAmount'))
            ->orderBy('investAmount','desc')
            ->limit(5)
            ->get();

        return view('ui.home',$data,compact('weeklyLeader','leader'));
    }
    public function tournament($name = null, $id){
        $now = Carbon::now();
        $tournament = Event::where('id',$id)->where('status',1)->firstOrFail();
        $data['page_title'] = "$tournament->name";
        $data['matches'] = Match::with('event')->where('event_id',$id)->whereStatus(1)->where('status', '!=' ,2)->where('end_date','>', $now)->orderBy('start_date','asc')->limit(10)->get();


        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();
        $data['gateway'] = GatewayCurrency::where('status',1)->get();
        $data['withdraw'] = WithdrawMethod::where('status',1)->count();
        return view('ui.tournament',$data);
    }


    public function about(){

        $data['page_title'] = "About Us";
        $data['users'] = User::count();
        $data['totalPrediction'] = BetInvest::count();
        $data['gateway'] = GatewayCurrency::where('status',1)->get();
        $data['withdraw'] = WithdrawMethod::where('status',1)->count();
        $data['testimonials'] = Testimonial::latest()->get();
        $data['howItWork'] = HowItWork::get();
        return view('ui.about',$data);
    }

    public function blog(){

        $data['page_title'] = "Blog";
        $data['blogs'] = Blog::latest()->paginate(3);
        $data['popular'] = Blog::orderBy('total_read','desc')->limit(5)->get();
        return view('ui.blogs',$data);
    }

    public function blogDetails($slug =  null, $id){

        $data['page_title'] = "Blog Details";
        $data['popular'] = Blog::orderBy('total_read','desc')->limit(5)->get();

        $blog = Blog::findOrFail($id);
        $blog->total_read +=1;
        $blog->save();


        return view('ui.blog-details',$data,compact('blog'));
    }

    public function faq(){

        $data['page_title'] = "FAQS";
        $data['faqs'] = Faq::all();
        return view('ui.faqs',$data);
    }
    public function terms(){

        $data['page_title'] = "Terms & Conditions";
        return view('ui.terms',$data);
    }
    public function policy(){

        $data['page_title'] = "Privacy & Policy";
        return view('ui.policy',$data);
    }

    public function contact(){

        $data['page_title'] = "Contact Us";
        return view('ui.contact',$data);
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60',
            'email' => 'required|max:191',
            'message' => 'required|max:191',
            'subject' => 'required|max:191',
        ]);

        send_contact($request->email,$request->name, $request->subject,$request->message);
        session()->flash('success','Send Successfully');
        return back();
    }

    public function cronMatchEnd(){
        $now = Carbon::now();
        Match::where('end_date','<', $now)->where('status',1)->update(['status' => 2]);
        BetQuestion::where('end_time','<', $now)->where('status',1)->update(['status' => 2]);



        $date = Carbon::today()->subDays(1);
        Deposit::where('created_at', '<=', $date)->where('status',0)->delete();


    }

}
