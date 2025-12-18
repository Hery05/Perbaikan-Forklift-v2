<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class forklift extends Model
{
    use HasFactory;

    protected $fillable = ['merk','tipe','kode_unit'];
    
    public function repairRequests()
    {
        return $this->hasMany(RepairRequest::class);
    }

}
