<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Represents an appointment in the system
 * 
 * This model handles appointment data including:
 * - User and contact information
 * - Schedule details (date/time)
 * - Appointment type (Internal/External)
 * - Status tracking
 * - Date/time formatting
 */
class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company_name',
        'address',
        'date',
        'time',
        'purpose',
        'description',
        'appointment_type',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'appointment_type' => 'Internal' // Default value
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = ['formatted_date', 'formatted_time'];

    /**
     * Get the formatted date for the appointment
     *
     * @return string|null
     */
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('Y-m-d') : null;
    }

    /**
     * Get the formatted time for the appointment
     *
     * @return string|null
     */
    public function getFormattedTimeAttribute()
    {
        return $this->time ? $this->time->format('H:i') : null;
    }

    /**
     * Format date for serialization
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the user that owns the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notifications for the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the external client for the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function external_client()
    {
        return $this->belongsTo(ExternalClient::class);
    }

    /**
     * Get the latest reminder for the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_reminder()
    {
        return $this->hasOne(Notification::class)
            ->where('type', 'manual_reminder')
            ->latest();
    }
}