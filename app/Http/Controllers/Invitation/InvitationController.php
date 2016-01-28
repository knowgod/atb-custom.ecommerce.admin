<?php

namespace App\Http\Controllers\Invitation;

use App\Models\Invitations\Entities\Invitation;
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

        $collectionParams = $this->prepareGridCollectionParams($request);

        $invitations = $this->inviteRepo->getInvitationsGridCollection(
                $collectionParams['filterBy'],
                $collectionParams['orderBy'],
                $collectionParams['perPage']
        );

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
        $invitation = new Invitation();
        $invitation
            ->setEmail($request->input('email'))
            ->setStatus(0)
            ->save();

        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    public function resend(Request $request){
        $invite = $this->inviteRepo->find($request->id);
        $this->sendEmail($request->user()->getEmail(), $invite->getEmail());
        $invite->setStatus(0)->save();
        return redirect($this->redirectTo)->with('message', $this->_invitationSuccessMessage);;
    }

    protected function sendEmail($fromEmail, $toEmail){
        Mail::send('invitation.email', ['email' => $toEmail], function ($message) use ($fromEmail, $toEmail){
            $message->from($fromEmail, 'NuMe');
            $message->to($toEmail, 'name')->subject($this->_invitationSubjectMessage);
        });
    }

    public function delete(Request $request){
        $this->inviteRepo->find($request->id)->remove();
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
