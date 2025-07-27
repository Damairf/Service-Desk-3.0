<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'reff_jabatan';
    protected $fillable = ['Nama_Jabatan'];
    protected $primaryKey = 'ID_Jabatan';

    public function user_jabatan(): HasMany{
        return $this -> hasMany(Status::class, "ID_Jabatan");
    }
}
