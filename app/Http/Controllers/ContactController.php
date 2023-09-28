<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;

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

}
