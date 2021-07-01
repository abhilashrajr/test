<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Feedbacks;

class FeedbackController extends Controller
{
    //
    public function store(Request $request){
        $request->validate([
            'fbemail' => 'required|email',
            'fbmsg' => 'required',
        ]);

        $feedback = new Feedbacks;
        $feedback->email = $request->fbemail;
        $feedback->message = $request->fbmsg;
        if($feedback->save()){
            return response()->json(['status'=>'success','message'=>'Feedback send successfully.']);
        }else{
            return response()->json(['status'=>'error', 'message'=>'Something went wrong!']); 
        }
    }

    public function index(){

        $feedbacks = Feedbacks::latest()->limit(100)->get()->toArray();
      
        return view('feedback.show', compact('feedbacks'));
    }
}
