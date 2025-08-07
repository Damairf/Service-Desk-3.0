<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Urgensi extends Model
{
    use HasFactory;

   protected $table = 'reff_urgensi';
   protected $primaryKey = 'ID_Urgensi';
   protected $fillable = ['Nama_Urgensi'];
   
   public function urgensi_pelayanan(): HasMany{
      return $this -> hasMany( Pelayanan::class, 'ID_Urgensi');
   }
}
