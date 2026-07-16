<?php

namespace App\Exports\Sheets;

use Illuminate\Http\Request;
use App\Models\Booking;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\Traits\AppliesBookingFilters;

class MastersStatsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    use AppliesBookingFilters;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Мастера';
    }

    public function headings(): array
    {
        return [
            'Мастер',
            'Количество записей'
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
        $base = Booking::query();

        $this->applyFilters($base);

        return $base
            ->join('masters', 'bookings.master_id', '=', 'masters.id')
            ->selectRaw('
                masters.name as master,
                COUNT(*) as total
            ')
            ->groupBy('masters.name')
            ->get()
            ->map(fn ($r) => [
                $r->master,
                $r->total,
            ]);
    }
}