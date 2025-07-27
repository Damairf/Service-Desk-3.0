<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelayanan;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelayanan extends Model
{
    protected $table = 'reff_jenis_pelayanan';
    protected $primaryKey = 'ID_Jenis_Pelayanan';
    protected $fillable = [
        'Nama_Jenis_Pelayan',
        'Persyaratan'
    ];


    public function pelayanan():HasMany
    {
        return $this->hasMany(Pelayanan::class, 'ID_Jenis_Pelayanan'); 
    }


}
