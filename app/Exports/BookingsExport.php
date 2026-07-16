<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Exports\Sheets\AnalyticsSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\BookingsListSheet;
use App\Exports\Sheets\MastersStatsSheet;
use App\Exports\Sheets\ServicesStatsSheet;
use App\Exports\Sheets\ClientsStatsSheet;

class BookingsExport implements WithMultipleSheets
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new BookingsListSheet($this->request);

        if ($this->request->include_master_stats) {
            $sheets[] = new MastersStatsSheet($this->request);
        }

        if ($this->request->include_service_stats) {
            $sheets[] = new ServicesStatsSheet($this->request);
        }

        if ($this->request->include_clients_stats) {
            $sheets[] = new ClientsStatsSheet($this->request);
        }
        
        if ($this->request->include_analytics) {
            $sheets[] = new AnalyticsSheet($this->request);
        }

        return $sheets;
    }
}