<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalClient extends Model
{
    use SoftDeletes; // Only if you included softDeletes in migration

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company_name',
        'address'
    ];

    // Add a relationship to appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Helper method to get full name
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Scope for searching clients
    public function scopeSearch($query, $term)
    {
        return $query->where(function($query) use ($term) {
            $query->where('first_name', 'LIKE', "%{$term}%")
                  ->orWhere('last_name', 'LIKE', "%{$term}%")
                  ->orWhere('email', 'LIKE', "%{$term}%")
                  ->orWhere('company_name', 'LIKE', "%{$term}%");
        });
    }
}
