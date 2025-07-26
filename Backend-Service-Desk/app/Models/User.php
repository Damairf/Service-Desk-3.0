<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'ID_User';
    protected $fillable = ['Nama_Depan', 'Nama_Belakang', 'NIP',  'Password', 'ID_Role', 'ID_Status','ID_Organisasi', 'ID_Jabatan' ];

    public function user_role(): HasMany
    {
        return $this->hasMany(Role::class, 'ID_Role'); 
    }
    public function user_jabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class, 'ID_Jabatan');
    }
    public function user_organisasi(): HasMany
    {
        return $this->hasMany(Organisasi::class, 'ID_Organisasi');
    }
    public function teknis_pelayanan(): HasMany
    {
        return $this->hasMany(Pelayanan::class, 'ID_Teknis');
    }
}