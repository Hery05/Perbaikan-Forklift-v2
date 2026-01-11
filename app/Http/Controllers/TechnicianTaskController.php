<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RepairRequest;
use App\Models\RepairLog;
use App\Models\SparepartRequest;
use App\Models\Sparepart;
use App\Models\User;
use App\Notifications\TaskNotification;

class TechnicianTaskController extends Controller
{
    /* ================= LIST TUGAS ================= */
    public function index()
    {
        $tasks = RepairRequest::with('forklift')
            ->where('technician_id', auth()->id())
            ->whereIn('status', [
                'DITUGASKAN',
                'SEDANG_DIKERJAKAN',
                'MENUNGGU_SPAREPART',
                'SPAREPART_TERSEDIA'
            ])
            ->latest()
            ->paginate(10);

        return view('technician.tasks', compact('tasks'));
    }

    /* ================= DETAIL ================= */
    public function show($id)
    {
        $task = RepairRequest::with(['forklift', 'user', 'technician', 'sparepartRequests.sparepart'])
            ->findOrFail($id);

        if ($task->technician_id !== auth()->id()) abort(403);

        return view('technician.detail', compact('task'));
    }

    /* ================= MULAI PERBAIKAN ================= */
    public function start($id)
    {
        $task = RepairRequest::findOrFail($id);
        if ($task->technician_id !== auth()->id()) abort(403);
        if ($task->status !== 'DITUGASKAN') return back()->with('error', 'Status tidak valid');

        $task->update([
            'status'   => 'SEDANG_DIKERJAKAN',
            'start_at' => now()
        ]);

        RepairLog::create([
            'repair_request_id' => $task->id,
            'user_id' => auth()->id(),
            'status' => 'SEDANG_DIKERJAKAN',
            'keterangan' => 'Teknisi mulai mengerjakan'
        ]);

        return back()->with('success', 'Perbaikan dimulai');
    }

    /* ================= SELESAIKAN ================= */
    public function finish(Request $request, $id)
    {
        $request->validate(['hasil_perbaikan' => 'required|string']);

        $task = RepairRequest::findOrFail($id);
        if ($task->technician_id !== auth()->id()) abort(403);
        if (!in_array($task->status, ['SEDANG_DIKERJAKAN', 'SPAREPART_TERSEDIA'])) {
            return back()->with('error', 'Task belum bisa diselesaikan');
        }

        $task->update([
            'status'          => 'SELESAI',
            'durasi_menit'    => $request->durasi_menit,
            'hasil_perbaikan' => $request->hasil_perbaikan
        ]);

        RepairLog::create([
            'repair_request_id' => $task->id,
            'user_id' => auth()->id(),
            'status' => 'SELESAI',
            'keterangan' => 'Perbaikan diselesaikan'
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Perbaikan berhasil diselesaikan');
    }

    /* ================= FORM SPAREPART ================= */
    public function requestSparepartForm($id)
    {
        $task = RepairRequest::with(['forklift', 'technician'])->findOrFail($id);

        if ($task->technician_id !== auth()->id()) abort(403);
        if ($task->status !== 'SEDANG_DIKERJAKAN') return back()->with('error', 'Tidak bisa ajukan sparepart');

        $spareparts = Sparepart::where('stok', '>', 0)->get();

        return view('technician.sparepart', compact('task', 'spareparts'));
    }

    /* ================= SIMPAN SPAREPART ================= */
    public function storeSparepart(Request $request, $id)
    {
        $request->validate([
            'sparepart_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $task = RepairRequest::findOrFail($id);

        if ($task->technician_id !== auth()->id()) {
            abort(403);
        }

        if ($task->status !== 'SEDANG_DIKERJAKAN') {
            return back()->with('error', 'Status tidak valid untuk request sparepart');
        }

        DB::transaction(function () use ($task, $request) {
            // Buat permintaan sparepart
            $sparepartRequest = SparepartRequest::create([
                'repair_request_id' => $task->id,
                'technician_id'    => auth()->id(),
                'forklift_id'      => $task->forklift_id,
                'sparepart_id'     => $request->sparepart_id,
                'jumlah'           => $request->jumlah,
                'status'           => 'DIPROSES'
            ]);

            // Update status task menjadi menunggu sparepart
            $task->update([
                'status' => 'MENUNGGU_SPAREPART'
            ]);

            // Log repair
            RepairLog::create([
                'repair_request_id' => $task->id,
                'user_id'           => auth()->id(),
                'status'            => 'MENUNGGU_SPAREPART',
                'keterangan'        => 'Menunggu sparepart'
            ]);

            // Notifikasi ke user sparepart/gudang
            $gudangUsers = User::where('role', 'sparepart')->get();
            foreach ($gudangUsers as $user) {
                $user->notify(new TaskNotification(
                    'Permintaan sparepart baru untuk forklift ' . $task->forklift->kode_forklift,
                    '/sparepart/requests'
                ));
            }
        });

        return redirect()->route('tasks.show', $task->id)
            ->with('warning', 'Permintaan sparepart dikirim ke gudang');
    }
}
