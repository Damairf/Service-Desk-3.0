<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubJenisPelayanan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Isi_Alur extends Model
{
    protected $table = 'reff_isi_alur';
    protected $primaryKey = 'ID_Isi_Alur';
    protected $fillable = [
        'Nama_Alur'
    ];
}