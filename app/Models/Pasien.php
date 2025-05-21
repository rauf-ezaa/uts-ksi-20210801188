<?php

namespace App\Models;

use App\Models\MedicalRecord;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'pasiens';
    protected $casts = ['nik' => 'encrypted'];
    protected $fillable = [
        'nama_lengkap',
        'no_rekam_medis',
        'tanggal_lahir',
        'alamat',
        'diagnosa',
        'riwayat',
        'kontak_darurat',
        'nik'
    ];

    public function MedicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
