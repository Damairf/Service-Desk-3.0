<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelayanan extends Model
{
    protected $table = 'reff_jenis_pelayanan';
    protected $primaryKey = 'ID_Jenis_Pelayanan';
    protected $fillable = [
        'Nama_Jenis_Pelayan',
        'Persyaratan'
    ];
}
