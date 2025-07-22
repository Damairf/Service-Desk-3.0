<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'reff_jabatan';
    protected $fillable = ['Nama_Jabatan'];
    protected $primaryKey = 'ID_Jabatan';

    public function user_jabatan(): BelongsTo{
        return $this -> belongsTo(Status::class, "ID_Jabatan");
    }
}
