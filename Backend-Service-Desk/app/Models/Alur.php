<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPelayanan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alur extends Model
{
    protected $table = 'alur';
    protected $primaryKey = 'ID_Alur';
    protected $fillable = [
        'ID_Jenis_Pelayanan',
        'ID_Isi_Alur'
    ];

    public function alur_jnsPelayanan():BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class, 'ID_Jenis_Pelayanan'); 
    }
    public function isi_alur(): BelongsTo
    {
        return $this->belongsTo(Isi_Alur::class, 'ID_Isi_Alur');
    }
    public function progress_to_alur(): HasMany
    {
        return $this->hasMany(ProgressAlur::class, 'ID_Alur');
    }
}