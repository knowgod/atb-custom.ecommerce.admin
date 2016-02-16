<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserFormRequest extends Request
{
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
        if ($this->route()->getName() == 'userUpdate') {
            return [
                'firstname' => 'required|max:255',
                'email'     => 'required|email|max:255|exists:App\Models\Users\Entities\User',
                'lastname'  => 'required|max:255',
                'password'  => 'sometimes|required|confirmed|min:6'
            ];
        }

        return [
            'firstname' => 'required|max:255',
            'lastname'  => 'required|max:255',
            'email'     => 'required|email|max:255|unique:App\Models\Users\Entities\User',
            'password'  => 'required|confirmed|min:6'
        ];
    }
}
