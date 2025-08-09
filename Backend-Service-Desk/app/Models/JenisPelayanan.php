<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelayanan;
use App\Models\SubJenisPelayanan;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelayanan extends Model
{
    protected $table = 'reff_jenis_pelayanan';
    protected $primaryKey = 'ID_Jenis_Pelayanan';
    protected $fillable = [
        'Nama_Jenis_Pelayanan'
    ];

    public function jenis_pelayanan():HasMany
    {
        return $this->hasMany(Pelayanan::class, 'ID_Jenis_Pelayanan'); 
    }
    public function Sub_JnsPelayanan():HasMany
    {
        return $this->hasMany(SubJenisPelayanan::class, 'ID_Jenis_Pelayanan');
    }
}