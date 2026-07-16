<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacancyApplication extends Model
{
    protected $fillable = ['vacancy_id', 'name', 'phone', 'email', 'status'];

    protected $casts = ['status' => 'string'];

    public function vacancy(): BelongsTo 
    { 
        return $this->belongsTo(Vacancy::class); 
    }
    
     
    public function getStatusRuAttribute()
    {
        return [
            'pending' => 'Новый',
            'reviewed' => 'Просмотрено',
        ][$this->status] ?? $this->status;
    }
}