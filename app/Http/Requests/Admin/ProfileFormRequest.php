<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ProfileFormRequest extends Request
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
        $rulesSet = [
            'firstname' => 'required|max:255',
            'email'     => 'required|email|max:255|exists:App\Models\Users\Entities\User',
            'lastname'  => 'required|max:255',
        ];
        if (Request::input('password')){
            $rulesSet = array_merge($rulesSet, ['password' => 'required|confirmed|min:6']);
        }

        return $rulesSet;
    }
}
