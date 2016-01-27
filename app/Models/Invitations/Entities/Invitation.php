<?php

namespace App\Models\Invitations\Entities;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'status'
    ];
}
