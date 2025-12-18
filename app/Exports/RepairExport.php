<?php

namespace App\Exports;

use App\Models\RepairRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class RepairExport implements FromCollection
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return RepairRequest::whereMonth('created_at', $this->bulan)->get();
    }
}
