<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
  

    protected $fillable = ['otp','user_id'];



    public function getIsExpiredAttribute()
    {
        return $this->created_at->addMinutes(5)->isPast();
    }

     public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope for non-expired OTPs
    public function scopeNotExpired($query, $validMinutes = 5)
    {
        return $query->where('created_at', '>=', now()->subMinutes($validMinutes));
    }
}
