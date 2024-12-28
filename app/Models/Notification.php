<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a notification in the system
 * 
 * This model handles notification data including:
 * - Appointment associations
 * - Notification types and messages
 * - Read status tracking
 * - Timestamp management
 */
class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'appointment_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    /**
     * Get the appointment associated with the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}