<?php

namespace App\Exports\Sheets;

use Illuminate\Http\Request;
use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\Traits\AppliesBookingFilters;

class ServicesStatsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    use AppliesBookingFilters;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Услуги';
    }

    public function headings(): array
    {
        return [
            'Услуга',
            'Всего',
            'Выполнено',
            'Отменено',
            'Конверсия %',
        ];
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        $base = Booking::query();

        $this->applyFilters($base);

        $rows = $base
            ->join('booking_service', 'bookings.id', '=', 'booking_service.booking_id')
            ->join('services', 'services.id', '=', 'booking_service.service_id')
            ->selectRaw('
                services.title as service,
                COUNT(bookings.id) as total,
                SUM(CASE WHEN bookings.status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN bookings.status = "cancelled" THEN 1 ELSE 0 END) as cancelled
            ')
            ->groupBy('services.title')
            ->get();

        return $rows->map(function ($r) {
            $conversion = $r->total > 0
                ? round(($r->completed / $r->total) * 100, 2)
                : 0;

            return [
                $r->service,
                (int) $r->total,
                (int) $r->completed,
                (int) $r->cancelled,
                $conversion,
            ];
        });
    }
}