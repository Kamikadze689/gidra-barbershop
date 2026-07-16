<?php

namespace App\Models;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'price_men',
        'price_master',
        'price_top',
        'category',
        'duration',
        'sort_order'
    ];

    public function bookings()
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_service'
        );
    }
}