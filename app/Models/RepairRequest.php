<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    protected $fillable = [
        'user_id',
        'coordinator_id',
        'technician_id',
        'forklift_id',
        'deskripsi_awal',
        'jenis_kerusakan',
        'prioritas',
        'status',
        'tanggal_diajukan',
        'tanggal_selesai',
        'hasil_perbaikan',
        'durasi_menit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function forklift()
    {
        return $this->belongsTo(Forklift::class);
    }

    public function logs()
    {
        return $this->hasMany(RepairLog::class);
    }
     public function sparepartRequests()
    {
        return $this->hasMany(SparepartRequest::class);
    }

}
