<?php

namespace App\Exports\Sheets;

use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Exports\Traits\AppliesBookingFilters;

class AnalyticsSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    use AppliesBookingFilters;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Аналитика';
    }

    public function headings(): array
    {
        return ['Показатель', 'Значение'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function array(): array
    {
        $base = Booking::query();
        $this->applyFilters($base);

        $total = (clone $base)->count();

        $completed = (clone $base)
            ->where('status', 'completed')
            ->count();

        $cancelled = (clone $base)
            ->where('status', 'cancelled')
            ->count();

        $active = (clone $base)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();

        $conversion = $total ? round($completed / $total * 100, 2) : 0;
        $cancelRate = $total ? round($cancelled / $total * 100, 2) : 0;

        $avg = (clone $base)
            ->selectRaw('customer_phone, COUNT(*) as cnt')
            ->groupBy('customer_phone')
            ->get()
            ->avg('cnt');

        return [
            ['Всего записей', $total],
            ['Выполнено', $completed],
            ['Отменено', $cancelled],
            ['Конверсия, %', $conversion],
            ['Доля отмен, %', $cancelRate],
        ];
    }
}