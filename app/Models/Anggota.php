<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggota extends Model
{
    use SoftDeletes;
    protected $table = 'anggotas';
    public static $view = 'anggota_view';

    protected $fillable = [
        'id_kelompok',
        'nik',
        'nama_anggota',
        'id_jabatan',
        'no_hp',
        'alamat',
        'id_kelurahan',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
