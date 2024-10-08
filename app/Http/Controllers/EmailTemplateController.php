<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\BirthdayPostPublish;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $data = EmailTemplate::with('getEmployeeName')->get();
        return view('email-template.index',compact('data'));
    }

    public function create()
    {
        return view('email-template.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = "$profileImage";
        }

        $subject = $request->subject;
        $data = [
            'message' => $request->message,
            'image' =>  $input['image'],
        ];

        $template = new BirthdayPostPublish($data, $subject);


        $emails = User::pluck('email');

        foreach ($emails as  $eml) {
            SendEmailJob::dispatch($eml, $template);
        }
    
        EmailTemplate::create($input);

        return redirect()->route('email.templates')

            ->with('message', 'Template created successfully.');
    }
}
