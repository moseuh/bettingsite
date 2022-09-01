<?php

namespace App\Http\Controllers\Admin;

use App\BetInvest;
use App\BetOption;
use App\BetQuestion;
use App\GeneralSettings;
use App\Http\Controllers\Controller;
use App\Match;
use App\Trx;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Event;
use Illuminate\Support\Facades\Auth;

class ProphecyManageController extends Controller
{

    public function tournament()
    {
        $data['page_title'] = 'Tournament Manage';
        $data['events'] = Event::latest()->get();
        return view('admin.tournament.index', $data);
    }

    public function updateTournament(Request $request)
    {
        $macCount = Event::where('name', $request->name)->where('id', '!=', $request->id)->count();
        if ($macCount > 0) {
            session()->flash('danger', 'Event Already Exist');
            return back();
        }

        if ($request->id == 0) {
            $data['name'] = $request->name;
            $data['slug'] = str_slug($request->name);
            $data['status'] = $request->status;
            $res = Event::create($data);
            if ($res) {
                session()->flash('success', 'Added Successfully!');
            } else {
                session()->flash('danger', 'Problem With Adding New Event');
            }

            return back();

        } else {
            $mac = Event::findOrFail($request->id);
            $mac['name'] = $request->name;
            $mac['slug'] = str_slug($request->name);
            $mac['status'] = $request->status;
            $res = $mac->update();

            if ($res) {
                session()->flash('success', 'Tournament Updated Successfully!');
            } else {
                session()->flash('danger', 'Problem With Updating Tournament');
            }

            return back();
        }
    }


    public function matches()
    {
        $data['page_title'] = 'Running Event';
        $data['matches'] = Match::with('event')->where('status', '!=', 2)->orderBy('start_date', 'asc')->paginate(25);
        return view('admin.event.index', $data);
    }

    public function closeMatches()
    {
        $data['page_title'] = 'Closed Event';
        $data['matches'] = Match::with('event')->orderBy('end_date', 'desc')->whereStatus(2)->paginate(25);
        return view('admin.event.closed-event', $data);
    }


    public function addMatch()
    {
        $data['page_title'] = 'Create Event';
        $data['events'] = Event::whereStatus(1)->get();
        return view('admin.event.create-event', $data);
    }

    public function saveMatch(Request $request)
    {
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'event_id.required' => 'Tournament must  be selected',
            'name.required' => 'Event must not be empty',
            'start_date.required' => 'Event start date must not be empty',
            'end_date.required' => 'Event end date must not be empty',
        ]);


        $in = request()->except('_token', 'start_time', 'end_time');
        $start_date = $request->start_date . ' ' . $request->start_time;
        $end_date = $request->end_date . ' ' . $request->end_time;
        $in['slug'] = str_slug($request->name);
        $in['start_date'] = Carbon::parse($start_date);
        $in['end_date'] = Carbon::parse($end_date);
        $in['status'] = $request->status == 'on' ? '1' : '0';
        $in['admin_id'] = Auth::guard('admin')->id();
        Match::create($in);

        session()->flash('success', 'Event Added Successfully!');
        return back();
    }

    public function editMatch($id)
    {
        $data['match'] = Match::find($id);
        $data['page_title'] = 'Edit Event';
        $data['tournaments'] = Event::whereStatus(1)->get();
        return view('admin.event.edit-event', $data);
    }

    public function updateMatch(Request $request)
    {
        $data = Match::find($request->id);
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'event_id.required' => 'Tournament must  be selected',
            'name.required' => 'Event must not be empty',
            'start_date.required' => 'Event start date must not be empty',
            'end_date.required' => 'Event end date must not be empty',
        ]);

        $in = request()->except('_token', 'start_time', 'end_time');
        $start_date = $request->start_date . ' ' . $request->start_time;
        $end_date = $request->end_date . ' ' . $request->end_time;

        $in['slug'] = str_slug($request->name);
        $in['start_date'] = Carbon::parse($start_date);
        $in['end_date'] = Carbon::parse($end_date);
        $in['status'] = $request->status == 'on' ? '1' : '0';
        $data->fill($in)->save();

        session()->flash('success', 'Event Update Successfully!');
        return back();
    }

    public function viewQuestion($id)
    {
        $data['match_id'] = Match::findOrFail($id);
        $data['page_title'] = $data['match_id']->name;
        $data['questions'] = BetQuestion::where('match_id', $id)->where('end_time', '>', Carbon::now())->paginate(20);
        return view('admin.event.questions', $data);
    }

    public function updateQuestion(Request $request)
    {

        $data = Match::findOrFail($request->match_id);
        $end_date = $request->end_date . ' ' . $request->end_time;
        if ($data->end_date > Carbon::parse($end_date)) {
            $data = BetQuestion::findOrFail($request->id);
            $in = request()->except('_token', 'end_time', 'end_date');
            $in['end_time'] = Carbon::parse($end_date);
            $data->fill($in)->save();

            session()->flash('success', 'Question Update Successfully!');
            return back();
        } else {
            session()->flash('warning', "Question duration time too large then Event Ending date");
            return back();
        }
    }

    public function saveQuestion(Request $request)
    {
        $this->validate($request, [

            'match_id' => 'required',
            'question' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'status' => 'required'
        ]);

        $end_date = $request->end_date . ' ' . $request->end_time;
        $data = Match::find($request->match_id);
        if ($data->end_date > Carbon::parse($end_date)) {
            BetQuestion::create([
                'match_id' => $request->match_id,
                'end_time' => Carbon::parse($end_date),
                'question' => $request->question,
                'admin_id' => Auth::guard('admin')->id()
            ]);
            session()->flash('success', 'Question Added Successfully!');
            return back();
        } else {
            session()->flash('danger', 'Question duration time too large \n  then Match ending date');
            return back();
        }
    }

    public function viewOption($id)
    {
        $data['ques'] = BetQuestion::with('match')->where('id',$id)->firstOrFail();
        $data['page_title'] = $data['ques']->question;
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate(20);
        return view('admin.event.options', $data);
    }

    public function createNewOption(Request $request)
    {
        $this->validate($request, [
            'ques_id' => 'required',
            'match_id' => 'required',
            'option_name' => 'required',
            'min_amo' => 'required',
            'bet_limit' => 'required',
            'ratio1' => 'required',
            'ratio2' => 'required',
            'status' => 'required'
        ]);


        BetOption::create([
            'match_id' => $request->match_id,
            'question_id' => $request->ques_id,
            'status' => $request->status,
            'option_name' => $request->option_name,
            'min_amo' => $request->min_amo,
            'ratio1' => $request->ratio1,
            'ratio2' => $request->ratio2,
            'admin_id' => Auth::guard('admin')->id()
        ]);
        session()->flash('success', 'Option Added Successfully!');
        return back();
    }

    public function updateOption(Request $request)
    {
        $data = BetOption::find($request->id);

        $this->validate($request, [
            'option_name' => 'required',
            'ratio1' => 'required|between:0,99.99',
            'ratio2' => 'required|between:0,99.99',
        ],
            [
                'name.required' => 'Option must not be empty',
                'ratio1.required' => 'ratio1 must not be empty',
                'ratio2.required' => 'ratio must not be empty',
            ]);
        $in = request()->except('_token');
        $data->fill($in)->save();

        session()->flash('success', 'Update Successfully!');
        return back();
    }


    public function endDateByQuestion()
    {
        $now = Carbon::now();
        $data['page_title'] = "Awaiting Winner";
        $data['questions'] = BetQuestion::with('match')->where('end_time', '<', $now)->orderBy('end_time', 'desc')->paginate(20);
        $data['access'] = json_decode(Auth::guard('admin')->user()->access);
        return view('admin.result.awaiting-list', $data);
    }

    public function refundBetInvest(Request $request)
    {
        $basic = GeneralSettings::first();
        $betQ = BetQuestion::where('id', $request->question_id)->where('match_id', $request->match_id)->latest()->first();
        $betQ->result = 1;
        $betQ->save();

        $betOption = BetOption::where('question_id', $betQ->id)->where('match_id', $request->match_id)->latest()->get();
        foreach ($betOption as $value) {
            $value->status = 3;  // refunded
            $value->admin_id = Auth::guard('admin')->id();
            $value->save();
        }

        $winner = BetInvest::where('betquestion_id', $request->question_id)->where('match_id', $request->match_id)->where('status', 0)->latest()->get();
        foreach ($winner as $dd) {
            $user = User::find($dd->user_id);
            $user->balance += $dd->invest_amount;
            $user->save();

            $mm = Match::whereId($request->match_id)->first();
            $tr = getTrx();
            Trx::create([
                'user_id' => $user->id,
                'amount' => $dd->invest_amount,
                'main_amo' => $user->balance,
                'charge' => 0,
                'type' => '+',
                'title' => $dd->invest_amount . ' ' . $basic->currency . " refunded by admin policy. <br>" . "\n Event : " . $mm->name . " ( Ques: " . $dd->ques->question . " => " . $dd->betoption->option_name . ")",
                'trx' => $tr
            ]);
            $dd->status = 2; // refunded
            $dd->admin_id = Auth::guard('admin')->id();
            $dd->remaining_balance = $user->balance; // remaining balance
            $dd->update();
        }

        session()->flash('success', 'Refunded Successfully!');

        return back();
    }


    public function awaitingWinnerUserlist($id)
    {
        $data['page_title'] = "Predictors List";
        $data['betQuestion'] = BetQuestion::find($id);
        $data['betInvest'] = BetInvest::where('betquestion_id', $id)->latest()->paginate(20);
        $data['access'] = json_decode(Auth::guard('admin')->user()->access);
        return view('admin.result.predictor-list', $data);
    }

    public function refundBetInvestSingleUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $basic = GeneralSettings::first();
        $invest = BetInvest::where('id', $request->id)->where('status', 0)->firstOrFail();

        $user = User::find($invest->user_id);
        $user->balance += $invest->invest_amount;
        $user->save();

        $mm = Match::whereId($invest->match_id)->first();
        $tr = getTrx();
        Trx::create([
            'user_id' => $user->id,
            'amount' => $invest->invest_amount,
            'main_amo' => $user->balance,
            'charge' => 0,
            'type' => '+',
            'title' => $invest->invest_amount . ' ' . $basic->currency . " refunded by admin policy. <br>" . "\n Event: " . $mm->name . " ( Ques: " . $invest->ques->question . " => " . $invest->betoption->option_name . ")",
            'trx' => $tr
        ]);
        $invest->status = 2; // refunded
        $invest->admin_id = Auth::guard('admin')->id();
        $invest->remaining_balance = $user->balance; // remaining balance
        $invest->update();

        session()->flash('success', 'Refunded Successfully!');
        return back();
    }
    public function viewOptionEndTime($id)
    {
        $data['ques'] = BetQuestion::findOrFail($id);
        $data['page_title'] = $data['ques']->question;
        $data['betoption'] = BetOption::whereQuestion_id($id)->paginate(20);
        $data['access'] = json_decode(Auth::guard('admin')->user()->access);
        return view('admin.result.threat-list', $data);
    }

    public function makeWinner(Request $request)
    {
        $basic = GeneralSettings::first();
        $winner = BetInvest::where('match_id', $request->match_id)->where('betquestion_id', $request->ques_id)->where('betoption_id', $request->betoption_id)->where('status', 0)->latest()->get();
        $losser = BetInvest::where('match_id',$request->match_id)->where('betquestion_id', $request->ques_id)->where('betoption_id', '!=', $request->betoption_id)->where('status', 0)->latest()->get();

        foreach ($winner as $dd) {
            $return_amo = $dd->return_amount;
            $charge =(($dd->return_amount - $dd->invest_amount) * $basic->win_charge)/100; //percent
            $user = User::find($dd->user_id);
            $user->balance +=  round(($return_amo - $charge) ,2);
            $user->save();

            $dd->status = 1;
            $dd->admin_id = Auth::guard('admin')->id();
            $dd->charge = round($charge, 2);
            $dd->update();

            Trx::create([
                'user_id' => $user->id,
                'amount' => round(($return_amo - $charge) ,2),
                'main_amo' => $user->balance,
                'charge' => round($charge, 2),
                'type' => '*',
                'title' => "<strong>Event:</strong> " . $dd->match->name." <br>( <strong> Ques:</strong> ".$dd->ques->question. " <strong>, Threat: ". $dd->betoption->option_name ." => Win)</strong>",
                'trx' => getTrx(),
            ]);
        }
        foreach ($losser as $dd) {
            $user = User::find($dd->user_id);
            $dd->status = -1;
            $dd->admin_id = Auth::guard('admin')->id();
            $dd->update();
        }

        $betQ = BetQuestion::find($request->ques_id);
        $betQ->result = 1;
        $betQ->update();

        $betStatus = BetOption::find($request->betoption_id);
        $betStatus->status = 2;
        $betStatus->update();

        $betlosser = BetOption::where('id', '!=', $request->betoption_id)->whereQuestion_id($request->ques_id)->whereMatch_id($request->match_id)->get();
        foreach ($betlosser as $data) {
            $data->status = -2;
            $data->update();
        }
        session()->flash('success', 'Make winner Successfully!');
        return back();
    }

    public function betOptionUserlist($id)
    {
        $data['page_title'] = "Prediction User List";
        $data['betoption'] = BetOption::with('question','match')->whereId($id)->firstOrFail();
        $data['betInvest'] = BetInvest::with('user')->where('betoption_id', $id)->latest()->paginate(20);
        return view('admin.result.predictors-option-side', $data);
    }


}
