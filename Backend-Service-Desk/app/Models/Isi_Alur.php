<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPelayanan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Isi_Alur extends Model
{
    protected $table = 'isi_alur';
    protected $primaryKey = 'ID_Isi_Alur';
    protected $fillable = [
        'Isi_Bagian_Alur'
    ];
}