<?php

namespace App\Http\Controllers\Invite;

use App\Models\Invitations\Repositories\InviteRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class InviteController extends Controller
{
    public $inviteRepo = null;
    protected $_itemsPerPage = 10;

    protected $redirectTo = '/invite/list';

    protected $_invitationSuccessMessage = 'Invitation has been sent successfully!';
    protected $_invitationDuplicateMessage = 'Invitation to this email has already been sent!';
    protected $_invitationDeleteMessage = 'Invitation has been successfully removed';

    protected $_invitationSubjectMessage = 'Invitation!';

    public function __construct(InviteRepository $inviteRepository){
        $this->inviteRepo = $inviteRepository;
    }

    public function index(Request $request)
    {
        if($request->has('filterBy')){
            $this->inviteRepo->applyFilters($request->input('filterBy'));
        }
        if($request->has(['orderBy', 'orderDirection'])){
            $this->inviteRepo->orderBy($request->input('orderBy'),$request->input('orderDirection'));
        }

        if($request->has(['orderBy', 'orderDirection'])){
            $this->inviteRepo->orderBy($request->input('orderBy'),$request->input('orderDirection'));
        }

        $invitations = $this->inviteRepo->getPaginatedInvitations($this->_itemsPerPage);
        return view('invite.list', array('collection' => $invitations));
    }

    public function create()
    {
        return view('invite.form');
    }

    public function store(Request $request)
    {
        $invite = $this->inviteRepo->getInvitationByEmail($request->input('email'));
        $message = $this->_invitationDuplicateMessage;

        if (!$invite) {
            $this->sendEmail($request->user()->getEmail(), $request->input('email'));
            $this->inviteRepo->create(
                [
                    'email'  => $request->input('email'),
                    'status' => '0',
                ]
            );
            $message = $this->_invitationSuccessMessage;
        }
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    public function resend(Request $request)
    {
        $invite = $this->inviteRepo->find($request->id, ['email']);

        $this->sendEmail($request->user()->getEmail(), $invite->email);

        $this->inviteRepo->update(
            ['status'=>0],
            $invite->email,
            'email'
        );
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    protected function sendEmail($fromEmail, $toEmail)
    {
        Mail::send('invite.email', ['email' => $toEmail], function ($message) use ($fromEmail, $toEmail) {
            $message->from($fromEmail, 'NuMe');
            $message->to($toEmail, 'name')->subject($this->_invitationSubjectMessage);
        });
    }

    public function delete(Request $request){
        $this->inviteRepo->find($request->id, ['email'])->delete();
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    public function massResend()
    {

    }
}
