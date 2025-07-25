<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pelayanan;

class JenisPelayanan extends Model
{
    protected $table = 'reff_jenis_pelayanan';
    protected $primaryKey = 'ID_Jenis_Pelayanan';
    protected $fillable = [
        'Nama_Jenis_Pelayan',
        'Persyaratan'
    ];


    public function pelayanan():BelongsTo
    {
        return $this->belongsTo(Pelayanan::class, 'ID_Pelayanan'); 
    }


}
