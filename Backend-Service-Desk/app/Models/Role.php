<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use HasFactory;

    protected $table = 'reff_role';
    protected $primaryKey = 'ID_Role';
    protected $fillable = ['Nama_Role'];

    public function user_role(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ID_Role'); 
    }
    
}
    
