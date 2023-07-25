<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use Notifiable;

    protected $table = 'karyawan';
    protected $primaryKey = 'nik';
    protected $fillable = [
        'nama_lengkap', 'jabatan', 'no_hp',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
