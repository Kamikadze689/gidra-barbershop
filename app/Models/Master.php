<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Master extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'photo',
        'experience',
        'specialization',
        'review_link'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($master) {
            if (empty($master->slug)) {
                $master->slug = Str::slug($master->name);
            }
        });

        static::updating(function ($master) {
            if ($master->isDirty('name')) {
                $master->slug = Str::slug($master->name);
            }
        });
    }
    
    public function getRouteKeyName()
    {
         
        return request()->is('admin/*') ? 'id' : 'slug';
    }
    
     
}