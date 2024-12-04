<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'date',
        'time',
        'purpose',
        'description',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    // Add these accessors for proper JSON serialization
    protected $appends = ['formatted_date', 'formatted_time'];

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('Y-m-d') : null;
    }

    public function getFormattedTimeAttribute()
    {
        return $this->time ? $this->time->format('H:i') : null;
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}