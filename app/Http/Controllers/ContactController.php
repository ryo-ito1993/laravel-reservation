<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSendmail;
use App\Mail\ContactAdminNotification;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function confirm(ContactRequest $request)
    {
        return view('contact.confirm', ['inputs' => $request->all()]);
    }

    public function send(ContactRequest $request)
    {
    $action = $request->input('action');
    $inputs = $request->except('action');

    if($action !== 'submit') {
        return redirect()
            ->route('contact.create')
            ->withInput($inputs);

    } else {
        Contact::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'message' => $inputs['message'],
        ]);

        Mail::to($inputs['email'])->send(new ContactSendmail($inputs));
        Mail::to('admin@example.com')->send(new ContactAdminNotification($inputs));
        //再送信を防ぐためにトークンを再発行
        $request->session()->regenerateToken();

        return view('contact.complete');
        }
    }
}
