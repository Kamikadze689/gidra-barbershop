<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'master_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'start_time',
        'end_time',
        'status',
        'review_token',
        'review_sent'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'review_sent' => 'boolean',
    ];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service');
    }
    
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    
     
    public function generateReviewToken()
    {
        $this->review_token = Str::random(64);
        $this->save();
        
        return $this->review_token;
    }

    public function getFormattedPhoneAttribute()
    {
        return preg_replace(
            '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/',
            '+$1 ($2) $3-$4-$5',
            $this->customer_phone
        );
    }
}