<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelayanan;
use App\Models\Alur;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressAlur extends Model
{
    protected $table = 'progress_alur';
    protected $primaryKey = 'ID_Progress_Alur';
    protected $fillable = [
        'ID_Pelayanan',
        'ID_Alur',
        'Is_Done'
    ];

    public function progress_to_pelayanan(): BelongsTo
    {
        return $this->belongsTo(Pelayanan::class, 'ID_Pelayanan');
    }
    public function progress_to_alur(): BelongsTo
    {
        return $this->belongsTo(Alur::class, 'ID_Alur')->with('isi_alur');
    }
}