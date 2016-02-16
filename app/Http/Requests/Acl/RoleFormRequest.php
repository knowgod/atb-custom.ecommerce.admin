<?php

namespace App\Http\Requests\Acl;

use App\Http\Requests\Request;

class RoleFormRequest extends Request
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
        if ($this->route()->getName() == 'roleCreate') {
            return [
                'name' => 'required|max:255|unique:App\Models\Acl\Entities\Role'
            ];
        } else {
            return [
                'name' => 'required|max:255|unique:App\Models\Acl\Entities\Role,name,'.Request::input('id')
            ];
        }
    }
}
