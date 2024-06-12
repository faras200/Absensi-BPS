<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $fillable = ['name', 'code', 'alamat', 'id_fingerprint', 'status', 'status_id'];

    protected $guarded = ['id'];

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }
    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }

    public function statuskaryawan()
    {
        return $this->hasOne(StatusKaryawan::class);
    }
}
