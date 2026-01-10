<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\RepairLog;
use App\Models\Forklift;
use App\Models\User;
use App\Notifications\SparepartStatusNotification;
use Illuminate\Http\Request;
use App\Notifications\TaskNotification;

class RepairRequestController extends Controller
{
    /**
     * ======================
     * INDEX (LIST REQUEST)
     * ======================
     */
    public function index()
    {
        // $user = auth()->user();

        // $requests = RepairRequest::with(['user','technician'])
        //     ->when($user->role !== 'coordinator', function ($q) use ($user) {
        //         $q->where('user_id', $user->id);
        //     })
        //     ->latest()
        //     ->paginate(10);

        // return view('repair_requests.index', compact('requests'));

        $user = auth()->user();

        if ($user->role === 'coordinator') {
            $requests = RepairRequest::with('forklift')
                ->latest()
                ->paginate(10);
        } else {
            $requests = RepairRequest::with('forklift')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('repair_requests.index', compact('requests'));
    }

    /**
     * ======================
     * LAPORAN (ADMIN)
     * ======================
     */
    public function report(Request $request)
    {
        $search = $request->get('q');

        $repairs = RepairRequest::with(['user', 'forklift'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('status', 'LIKE', "%{$search}%")
                        ->orWhere('deskripsi_awal', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('forklift', function ($f) use ($search) {
                            $f->where('kode_forklift', 'LIKE', "%{$search}%")
                                ->orWhere('merk', 'LIKE', "%{$search}%")
                                ->orWhere('tipe', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('reports.repairs', compact('repairs', 'search'));
    }


    /**
     * ======================
     * FORM AJUKAN PERBAIKAN
     * ======================
     */
    public function create()
    {
        $forklifts = Forklift::orderBy('kode_forklift')->get();
        return view('repair_requests.create', compact('forklifts'));
    }

    /**
     * ======================
     * SIMPAN PERMINTAAN
     * ======================
     */
    public function store(Request $request)
    {
        $request->validate([
            'forklift_id'    => 'required|exists:forklifts,id',
            'deskripsi_awal' => 'required'
        ]);

        $repair = RepairRequest::create([
            'user_id'          => auth()->id(),
            'forklift_id'      => $request->forklift_id,
            'deskripsi_awal'   => $request->deskripsi_awal,
            'status'           => 'DIAJUKAN',
            'tanggal_diajukan' => now()
        ]);

        RepairLog::create([
            'repair_request_id' => $repair->id,
            'user_id'           => auth()->id(),
            'status'            => 'DIAJUKAN',
            'keterangan'        => 'Permintaan diajukan oleh user'
        ]);

        return redirect('/reports/repairs')
            ->with('success', 'Permintaan perbaikan berhasil diajukan');
    }

    /**
     * ======================
     * VALIDASI COORDINATOR
     * ======================
     */
    public function edit($id)
    {
        $repair = RepairRequest::with('forklift')->findOrFail($id);
        $forklifts = Forklift::orderBy('kode_forklift')->get();

        return view('repair_requests.edit', compact('repair', 'forklifts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'forklift_id'     => 'required|exists:forklifts,id',
            'jenis_kerusakan' => 'required',
            'prioritas'       => 'required'
        ]);

        $repair = RepairRequest::findOrFail($id);

        $repair->update([
            'coordinator_id' => auth()->id(),
            'forklift_id'    => $request->forklift_id,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'prioritas'      => $request->prioritas,
            'status'         => 'DITUGASKAN'
        ]);

        RepairLog::create([
            'repair_request_id' => $repair->id,
            'user_id'           => auth()->id(),
            'status'            => 'DITUGASKAN',
            'keterangan'        => 'Permintaan divalidasi oleh coordinator'
        ]);

        return redirect('/repair-requests')
            ->with('success', 'Permintaan berhasil divalidasi');
    }

    /**
     * ======================
     * FORM ASSIGN TEKNISI
     * ======================
     */
    public function assignForm($id)
    {
        $repair = RepairRequest::with('forklift')->findOrFail($id);
        $technicians = User::where('role', 'technician')->get();

        return view('repair_requests.assign', compact('repair', 'technicians'));
    }

    /**
     * ======================
     * SIMPAN ASSIGN
     * ======================
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|exists:users,id'
        ]);

        $repair = RepairRequest::findOrFail($id);

        $repair->update([
            'technician_id' => $request->technician_id,
            'status'        => 'DITUGASKAN'
        ]);

        RepairLog::create([
            'repair_request_id' => $repair->id,
            'user_id'           => auth()->id(),
            'status'            => 'DITUGASKAN',
            'keterangan'        => 'Teknisi ditugaskan'
        ]);

        // Notifikasi ke teknisi

        $technician = User::find($request->technician_id);

        $technician->notify(
            new TaskNotification(
                'Anda mendapat tugas perbaikan forklift',
                url('/tasks/' . $repair->id)
            )
        );

        return redirect('/repair-requests')
            ->with('success', 'Teknisi berhasil ditugaskan');
    }
}
