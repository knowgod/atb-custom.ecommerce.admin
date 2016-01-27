<?php

namespace App\Http\Controllers\Invitation;

use App\Models\Invitations\Repositories\InvitationRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Policies\InvitationPolicy as AclPolicy;



class InvitationController extends Controller {
    public $inviteRepo = null;
    protected $_itemsPerPage = 10;

    protected $redirectTo = '/invitation/list';

    protected $_invitationSuccessMessage = 'Invitation has been sent successfully!';
    protected $_invitationDuplicateMessage = 'Invitation to this email has already been sent!';
    protected $_invitationDeleteMessage = 'Invitation has been successfully removed';

    protected $_invitationSubjectMessage = 'Invitation!';

    public function __construct(InvitationRepository $inviteRepository){
        $this->inviteRepo = $inviteRepository;
    }

    public function index(Request $request){

        $this->authorize('index', new AclPolicy());

        if ($request->has('filterBy')){
            $this->inviteRepo->applyFilters($request->input('filterBy'));
        }
        if ($request->has(['orderBy', 'orderDirection'])){
            $this->inviteRepo->orderBy($request->input('orderBy'), $request->input('orderDirection'));
        }

        if ($request->has(['orderBy', 'orderDirection'])){
            $this->inviteRepo->orderBy($request->input('orderBy'), $request->input('orderDirection'));
        }

        $invitations = $this->inviteRepo->getPaginatedInvitations($this->_itemsPerPage);
        return view('invitation.list', array('collection' => $invitations));
    }

    public function create(){
        return view('invitation.form');
    }

    public function store(Request $request){

        $this->authorize('sendEmail', new AclPolicy());

        $validator = $this->createValidator($request->all());
        if ($validator->fails()){
            return $this->throwValidationException(
                    $request, $validator
            );
        }

        $this->sendEmail($request->user()->getEmail(), $request->input('email'));
        $this->inviteRepo->create(
                [
                        'email'  => $request->input('email'),
                        'status' => '0',
                ]
        );
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    public function resend(Request $request){
        $invite = $this->inviteRepo->find($request->id, ['email']);

        $this->sendEmail($request->user()->getEmail(), $invite->email);

        $this->inviteRepo->update(
                ['status' => 0],
                $invite->email,
                'email'
        );
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    protected function sendEmail($fromEmail, $toEmail){
        Mail::send('invitation.email', ['email' => $toEmail], function ($message) use ($fromEmail, $toEmail){
            $message->from($fromEmail, 'NuMe');
            $message->to($toEmail, 'name')->subject($this->_invitationSubjectMessage);
        });
    }

    public function delete(Request $request){
        $this->inviteRepo->find($request->id, ['email'])->delete();
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    public function massResend(){

    }

    protected function createValidator(array $data){

        $rules = ['email' => 'required|email|max:255|unique:invitations'];
        $customMessages = ['email.unique' => 'Such invitation already exists.'];
        return Validator::make($data, $rules, $customMessages);
    }
}
