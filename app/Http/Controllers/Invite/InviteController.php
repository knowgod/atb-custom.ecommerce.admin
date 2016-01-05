<?php

namespace App\Http\Controllers\Invite;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class InviteController extends Controller
{
    public function create()
    {
        return view('invite.form');
    }

    public function store(Request $request)
    {
        Mail::send('invite.email', ['email' => $request->email], function ($message) use ($request) {
            $message->from($request->user()->email, 'NuMe');

            $message->to($request->email, 'name')->subject('Invitation!');
        });

        return Redirect::route('invite')->with('message', 'Invitation has been sent successfully!');
    }
}
