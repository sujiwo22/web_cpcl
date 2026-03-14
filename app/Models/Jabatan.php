<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Jabatan extends Model
{
    use SoftDeletes;
    protected $table = 'jabatans';
    // public static $view = 'kecamatan_view';

    protected $fillable = [
        'nama_jabatan',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
