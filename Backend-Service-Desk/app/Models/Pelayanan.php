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
    protected $casts = [
        'Is_Done' => 'boolean'
    ];
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
        'Insiden',
        'ID_Teknis',
        'Is_Done',
        'BA_Path',
        'SLA_Path',
        'Rating',
        'Isi_Survey',
        'Hasil_Pemenuhan_Path'
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
    public function unit_pelayanan(): BelongsTo{
        return $this -> belongsTo(User::class, 'ID_Unit');
    }
    public function progress_to_pelayanan(): HasMany
    {
        return $this->hasMany(ProgressAlur::class, 'ID_Pelayanan');
    }
}