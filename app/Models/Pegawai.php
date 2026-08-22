<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'profesi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
