<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absen';

    protected $guarded = ['id'];

    public function scopeharian($query)
    {
        return $query->where('tgl_absen', now()->format('Y-m-d'));
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
