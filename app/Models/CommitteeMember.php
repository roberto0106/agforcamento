<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'document',
        'phone',
        'course',
    ];
}
