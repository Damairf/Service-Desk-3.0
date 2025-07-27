<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pelayanan extends Model
{
    protected $table = 'Pelayanan';
    protected $primaryKey = 'ID_Pelayanan';
     public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'Perihal',
        'Deskripsi',
        'Lampiran',
        'Lampiran_Path',
        'Surat_Dinas_Path',
        'ID_Status',
        'ID_User',
        'ID_Jenis_Pelayanan',
        'ID_Unit',
        'ID_Teknis',
        'Rating',
        'Isi_Survey',
        'Surat_Laporan_Hasil'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $last = static::orderBy('ID_Pelayanan', 'desc')->first();
            if ($last) {
                $number = (int) substr($last->ID_Pelayanan, 2);
                $newNumber = $number + 1;
            } else {
                $newNumber = 1;
            }

            $model->ID_Pelayanan = 'P-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        });
    }
    public function User(): BelongsTo{
        return $this -> belongsTo( User::class, 'ID_User');
    }
    public function Jenis_Pelayanan(): BelongsTo{
        return $this -> belongsTo( JenisPelayanan::class, 'ID_Jenis_Pelayanan');
    }
    public function status_pelayanan(): BelongsTo{
        return $this -> belongsTo(Status::class, 'ID_Status');
    }
    public function teknis_pelayanan(): BelongsTo{
        return $this -> belongsTo(User::class, 'ID_Teknis');
    }
}