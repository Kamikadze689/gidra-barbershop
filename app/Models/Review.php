<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'text',
        'date',
        'approved',
        'booking_id'
    ];

    protected $casts = [
        'date' => 'date',
        'approved' => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}