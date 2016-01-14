<?php

namespace App\Models\Invitations\Entities;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email',
        'status'
    ];
}
