<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKaryawan extends Model
{
    use HasFactory;
    protected $table = 'status_karyawan';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
