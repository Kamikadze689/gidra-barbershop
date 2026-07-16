<?php

namespace App\Exports\Sheets;

use App\Models\Booking;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\Traits\AppliesBookingFilters;
use App\Exports\Traits\BookingMetrics;

class BookingsListSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    use AppliesBookingFilters;
    use BookingMetrics;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Записи';
    }

    public function headings(): array
    {
        return [
            'Дата',
            'Время',
            'Мастер',
            'Услуги',
            'Клиент',
            'Телефон',
            'Email',
            'Статус',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        $query = Booking::with(['master', 'services']);

        $this->applyFilters($query);

        return $query->get()->map(function ($booking) {
            return [
                $booking->start_time->format('d.m.Y'),
                $booking->start_time->format('H:i'),
                $booking->master?->name,
                $booking->services->pluck('title')->join(', '),
                $booking->customer_name,
                $booking->customer_phone,
                $booking->customer_email,
                $this->statusLabel($booking->status),
            ];
        });
    }
}