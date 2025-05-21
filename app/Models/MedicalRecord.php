<?php

namespace App\Models;

use App\Models\User;
use App\Models\Docter;
use App\Models\Pasien;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasRoles;
    protected $table = 'medical_records';
    protected $fillable = [
        'obat',
        'diagnosa',
        'pasien_id',
        'docter_id'
    ];

    public function Pasien(){
        return $this->belongsTo(Pasien::class);
    }

    public function Doctor(){
        return $this->belongsTo(Docter::class,'id');
    }
}
