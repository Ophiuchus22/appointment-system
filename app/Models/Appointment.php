<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'college',
        'email',
        'phone_number',
        'purpose',
        'date',
        'time',
        'status'
    ];
}
