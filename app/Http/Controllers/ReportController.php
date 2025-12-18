<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /* ================= HALAMAN REPORT ================= */
    public function index(Request $request)
    {
        $bulan = $request->bulan;

        $repairs = RepairRequest::with(['forklift','technician'])
            ->where('status', 'SELESAI')
            ->when($bulan, function ($q) use ($bulan) {
                $q->whereMonth('created_at', $bulan);
            })
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('repairs', 'bulan'));
    }

    /* ================= EXPORT PDF ================= */
    public function pdf(Request $request)
    {
        $bulan = $request->bulan;

        $data = RepairRequest::with(['forklift','technician'])
            ->where('status','SELESAI')
            ->when($bulan, function ($q) use ($bulan) {
                $q->whereMonth('created_at', $bulan);
            })
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact('data','bulan'))
                    ->setPaper('A4','landscape');

        return $pdf->download('laporan-perbaikan.pdf');
    }
}
