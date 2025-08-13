<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelayanan;
use App\Models\JenisPelayanan;
use App\Models\Alur;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubJenisPelayanan extends Model
{
    protected $table = 'reff_sub_jenis_pelayanan';
    protected $primaryKey = 'ID_Sub_Jenis_Pelayanan';
    protected $fillable = [
        'Nama_Sub_Jenis_Pelayanan',
        'ID_Jenis_Pelayanan',
        'Persyaratan'
    ];
    
    public function sub_jenis_pelayanan():HasMany
    {
        return $this->hasMany(Pelayanan::class, 'ID_Sub_Jenis_Pelayanan'); 
    }
    public function Sub_JnsPelayanan():BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class, 'ID_Jenis_Pelayanan');
    }
    public function alur_subjnsPelayanan():HasMany
    {
        return $this->hasMany(Alur::class, 'ID_Sub_Jenis_Pelayanan'); 
    }
}