<?php

namespace App\Models;

use App\Models\User;
use App\Models\MedicalRecord;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Docter extends Model
{
    use HasRoles;
    protected $table = 'docters';
    protected $casts = ['nip'=>'encrypted'];
    protected $fillable = [
        'user_id',
        'nip',
        'spesialis',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function MedicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
