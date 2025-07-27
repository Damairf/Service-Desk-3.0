<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPelayanan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alur extends Model
{
    protected $table = 'alur';
    protected $primaryKey = 'ID_Alur';


    public function alur_jnsPelayanan():BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class, 'ID_Jenis_Pelayanan'); 
    }


}
