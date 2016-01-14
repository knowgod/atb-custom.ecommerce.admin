<?php

namespace App\Http\Controllers\Invite;

use App\Models\Invitations\Repositories\InviteRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class InviteController extends Controller
{
    public $inviteRepo = null;
    protected $_itemsPerPage = 10;

    public function __construct(InviteRepository $inviteRepository){
        $this->inviteRepo = $inviteRepository;
    }

    public function index()
    {
        $invitations = $this->inviteRepo->getPaginatedInvitations($this->_itemsPerPage);
        return view('invite.list', array('collection' => $invitations));
    }

    public function create()
    {
        return view('invite.form');
    }

    public function store(Request $request)
    {
        Mail::send('invite.email', ['email' => $request->input('email')], function ($message) use ($request) {
            $message->from($request->user()->email, 'NuMe');
            $message->to($request->input('email'), 'name')->subject('Invitation!');
        });

        $this->inviteRepo->create(
            [
                'email'  => $request->input('email'),
                'status' => '0',
            ]
        );

        return Redirect::route('invite/list')->with('message', 'Invitation has been sent successfully!');
    }

    public function resend(Request $request)
    {

    }

    public function massResend()
    {

    }
}
