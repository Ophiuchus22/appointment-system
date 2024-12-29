<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'causer_id',
        'causer_type',
        'event',
        'description',
        'subject_id',
        'subject_type'
    ];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
