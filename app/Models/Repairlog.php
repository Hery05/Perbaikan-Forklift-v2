<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairLog extends Model
{
    protected $table = 'repairlogs';
    
    protected $fillable = [
        'repair_request_id',
        'user_id',
        'status',
        'keterangan'
    ];

    public function request()
    {
        return $this->belongsTo(RepairRequest::class, 'repair_request_id');
    }
}
