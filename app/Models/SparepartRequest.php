<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartRequest extends Model
{
    protected $fillable = [
    'repair_request_id',
    'technician_id',
    'forklift_id',
    'nama_sparepart',
    'jumlah',
    'status'
];


   public function repairRequest()
    {
        return $this->belongsTo(RepairRequest::class, 'repair_request_id');
    }
}

