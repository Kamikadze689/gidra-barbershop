<?php

namespace App\Exports\Traits;

trait BookingMetrics
{
    protected function statusLabel($status): string
    {
        return match ($status) {
            'pending' => 'Ожидает',
            'confirmed' => 'Подтверждена',
            'completed' => 'Выполнена',
            'cancelled' => 'Отменена',
            default => $status,
        };
    }

    protected function activeStatuses(): array
    {
        return ['pending', 'confirmed', 'completed'];
    }
}