<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'id';

    // Jika kolom primary key tidak auto-increment (opsional)
    public $incrementing = true;

    // Jika tipe primary key bukan integer (opsional)
    protected $keyType = 'int';

    // Kolom yang bisa diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'remember_token',
        'email_verified_at'
    ];

    // Kolom yang disembunyikan saat dikonversi ke array/json
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke tabel roles
    public function role()
    {
        // Asumsi: kolom foreign key di users = role_id, dan di roles = id
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
