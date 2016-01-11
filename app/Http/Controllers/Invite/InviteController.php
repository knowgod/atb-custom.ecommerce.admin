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
        Mail::send('invite.email', ['email' => $request->email], function ($message) use ($request) {
            $message->from($request->user()->email, 'NuMe');
            $message->to($request->email, 'name')->subject('Invitation!');
        });

        return Redirect::route('invite')->with('message', 'Invitation has been sent successfully!');
    }

    public function resend(Request $request)
    {
        var_dump($request);die;
    }

    public function massResend()
    {

    }
}
