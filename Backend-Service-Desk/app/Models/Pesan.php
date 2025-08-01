<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pesan extends Model
{
    protected $table = 'pesan';
    protected $primaryKey = 'ID_Pesan';
    protected $fillable = ['ID_User', 'ID_Pelayanan','Pesan'];

    public function pesan_user(): BelongsTo{
        return $this->belongsTo(User::class, 'ID_User'); 
    }

    public function pesan_pelayanan(): BelongsTo{
        return $this->belongsTo(Pelayanan::class, 'ID_Pelayanan'); 
    }
}
