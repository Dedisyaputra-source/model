<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    protected $incrementing = false;
    protected $keyType = 'string';
    protected $timestamp = false;

    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'updated_date';
    // protected $connection = 'sqlite';

    protected $fillable = [
        'nis',
        'name',
        'jk',
        'alamat',
        'tmp_lahir',
        'tgl_lahir',
        'telepon',
        'id_jurusan',
        'nilai'
    ];
}
