<?php

namespace App\Http\Requests\Invitation;

use App\Http\Requests\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Policies\InvitationPolicy as AclPolicy;

class InvitationFormRequest extends Request
{
    use AuthorizesRequests {
        authorize as traitAuthorize;
    }

    protected $_invitationDuplicateMessage = 'Invitation to this email has already been sent!';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:App\Models\Invitations\Entities\Invitation'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => $this->_invitationDuplicateMessage
        ];
    }
}
