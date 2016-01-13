<?php

namespace App\Models\Users\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'fullname',
            'firstname',
            'lastname',
            'password',
            'google_id',
            'google_avatar_img',
            'register_source',
            'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
            'password', 'remember_token',
    ];

    public function toJson($options = JSON_HEX_TAG | JSON_HEX_APOS){
        return json_encode($this->jsonSerialize(), $options);
    }
}
