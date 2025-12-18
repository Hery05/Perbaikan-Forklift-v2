<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total = RepairRequest::count();

        $byStatus = RepairRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total','status');

        $byTechnician = RepairRequest::select('technician_id', DB::raw('count(*) as total'))
            ->whereNotNull('technician_id')
            ->groupBy('technician_id')
            ->with('technician')
            ->get();

        return view('dashboard.index', compact(
            'total','byStatus','byTechnician'
        ));
    }
}
