<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelayanan extends Model
{
    protected $table = 'Pelayanan';
    protected $primaryKey = 'ID_Pelayanan';
    protected $fillable = [
        'Perihal',
        'Deskripsi',
        'Lampiran',
        'Lampiran_Path',
        'Surat_Dinas_Path',
        'ID_User',
        'ID_Jenis_Pelayanan',
        'ID_Unit',
        'ID_Teknis',
        'Rating',
        'Isi_Survey',
        'Surat_Laporan_Hasil'
    ];

    public function User(): BelongsTo{
        return $this -> belongsTo( Organisasi::class, 'ID_User','ID_User');
    }
    public function Jenis_Pelayanan(): HasMany{
        return $this -> hasMany( Organisasi::class, 'ID_Jenis_Pelayanan','ID_Jenis_Pelayanan');
    }

}
