<?php

namespace App\Http\Controllers;

use App\Models\SparepartRequest;
use App\Models\RepairLog;
use Illuminate\Http\Request;
use App\Notifications\SparepartStatusNotification;

class SparepartController extends Controller
{

    public function request(Request $request)
    {
        $keyword = $request->q;

        $requests = SparepartRequest::with([
            'repairRequest',
            'repairRequest.forklift',
            'repairRequest.technician'
        ])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('sparepart_id', 'LIKE', "%$keyword%")
                        ->orWhereHas('repairRequest', function ($r) use ($keyword) {
                            $r->where('deskripsi_awal', 'LIKE', "%$keyword%")
                                ->orWhereHas('forklift', function ($f) use ($keyword) {
                                    $f->where('kode_forklift', 'LIKE', "%$keyword%")
                                        ->orWhere('merk', 'LIKE', "%$keyword%")
                                        ->orWhere('tipe', 'LIKE', "%$keyword%");
                                });
                        });
                });
            })
            ->latest()
            ->paginate(10);

        $requests->appends(['q' => $keyword]); // tetap pertahankan query saat paginate

        return view('sparepart.request', compact('requests', 'keyword'));
    }

    /**
     * LIST PERMINTAAN SPAREPART (ROLE: SPAREPART)
     */
    public function index()
    {
        $requests = SparepartRequest::with([
            'repairRequest',
            'repairRequest.forklift',
            'repairRequest.technician'
        ])
            ->latest()
            ->paginate(10);

        return view('sparepart.index', compact('requests'));
    }

    /**
     * UPDATE STATUS SPAREPART
     * STATUS VALID:
     * - DISETUJUI
     * - DITOLAK
     */
    public function updateStatus($id, $status)
    {
        if (!in_array($status, ['DISETUJUI', 'DITOLAK'])) {
            abort(400, 'Status tidak valid');
        }

        $sparepart = SparepartRequest::findOrFail($id);
        $repair = $sparepart->repairRequest;

        // update status sparepart
        $sparepart->update([
            'status' => $status
        ]);

        /**
         * JIKA DISETUJUI
         * → repair lanjut
         */
        if ($status === 'DISETUJUI' && $repair) {
            $repair->update([
                'status' => 'SPAREPART_TERSEDIA'
            ]);
        }

        /**
         * JIKA DITOLAK
         * → repair selesai
         * → isi keterangan
         */
        if ($status === 'DITOLAK' && $repair) {

            // fallback jika belum ada hasil
            $repair->update([
                'status' => 'SELESAI',
                'hasil_perbaikan' => $repair->hasil_perbaikan
                    ?? 'Perbaikan tidak dapat dilanjutkan karena sparepart tidak tersedia',
                'durasi_menit' => $repair->durasi_menit ?? 0
            ]);
        }


        // LOG AKTIVITAS
        RepairLog::create([
            'repair_request_id' => $sparepart->repair_request_id,
            'user_id' => auth()->id(),
            'status' => 'SPAREPART_' . $status,
            'keterangan' => $status === 'DITOLAK'
                ? 'Sparepart ditolak, perbaikan dihentikan'
                : 'Sparepart disetujui'
        ]);

        return back()->with('success', 'Status sparepart berhasil diperbarui');
    }

    public function approve($id)
    {
        $sp = SparepartRequest::with('repairRequest')->findOrFail($id);

        $sp->update(['status' => 'TERSEDIA']);
        $sp->repairRequest->update(['status' => 'SEDANG_DIKERJAKAN']);

        // NOTIFIKASI KE TEKNISI
        $sp->repairRequest->technician
            ->notify(new SparepartStatusNotification(
                $sp->repair_request_id,
                'TERSEDIA',
                $sp->nama_sparepart
            ));

        return back()->with('success', 'Sparepart tersedia');
    }

    public function reject($id)
    {
        $sp = SparepartRequest::with('repairRequest')->findOrFail($id);

        $sp->update(['status' => 'TIDAK TERSEDIA']);

        $sp->repairRequest->technician
            ->notify(new SparepartStatusNotification(
                $sp->repair_request_id,
                'TIDAK TERSEDIA',
                $sp->nama_sparepart
            ));

        return back()->with('warning', 'Sparepart tidak tersedia');
    }
}
