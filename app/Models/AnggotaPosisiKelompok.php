<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaPosisiKelompok extends Model
{
    use SoftDeletes;
    protected $table = 'anggota_posisi_kelompoks';
    public static $view = 'anggota_posisi_kelompok_view';

    protected $fillable = [
        'id_anggota',
        'id_kelompok',
        'status',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
