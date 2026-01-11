<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartRequest extends Model
{
    protected $table = 'sparepart_requests';

    protected $fillable = [
        'repair_request_id',
        'technician_id',
        'forklift_id',
        'sparepart_id',
        'jumlah',
        'status'
    ];

    // ================= Relationship =================
    // App/Models/SparepartRequest.php
public function sparepart()
{
    return $this->belongsTo(Sparepart::class, 'sparepart_id'); // kolom foreign key sparepart_id
}


    public function repairRequest()
    {
        return $this->belongsTo(RepairRequest::class, 'repair_request_id', 'id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id', 'id');
    }

    public function forklift()
    {
        return $this->belongsTo(Forklift::class, 'forklift_id', 'kode_forklift');
    }
}


