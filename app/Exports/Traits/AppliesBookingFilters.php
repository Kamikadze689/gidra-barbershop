<?php

namespace App\Exports\Traits;

trait AppliesBookingFilters
{
    protected function applyFilters($query)
    {
        $request = $this->request;

        $query->when($request->date_from, function ($q) use ($request) {
            $q->whereDate('bookings.start_time', '>=', $request->date_from);
        });

        $query->when($request->date_to, function ($q) use ($request) {
            $q->whereDate('bookings.start_time', '<=', $request->date_to);
        });

        $query->when($request->master_id, function ($q) use ($request) {
            $q->where('bookings.master_id', $request->master_id);
        });

        $query->when($request->status, function ($q) use ($request) {
            $q->where('bookings.status', $request->status);
        });

        $query->when($request->service_id, function ($q) use ($request) {
            $q->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service_id);
            });
        });

        $query->when($request->customer_name, function ($q) use ($request) {
            $q->where('bookings.customer_name', 'like', "%{$request->customer_name}%");
        });

        $query->when($request->customer_phone, function ($q) use ($request) {
            $q->where('bookings.customer_phone', 'like', "%{$request->customer_phone}%");
        });

        return $query;
    }
}