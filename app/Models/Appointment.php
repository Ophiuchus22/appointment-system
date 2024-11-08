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
        'phone_number',
        'description', 
        'purpose',
        'date',
        'time',
        'status'
    ];
}
