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

class ClientsStatsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    use AppliesBookingFilters;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Клиенты';
    }

    public function headings(): array
    {
        return [
            'Клиент',
            'Телефон',
            'Посещений'
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

        return $base
            ->selectRaw('customer_name, customer_phone, COUNT(*) as visits')
            ->groupBy('customer_name', 'customer_phone')
            ->get()
            ->map(fn ($r) => [
                $r->customer_name,
                $r->customer_phone,
                $r->visits,
            ]);
    }
}