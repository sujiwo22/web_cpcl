<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelurahan extends Model
{
    use SoftDeletes;
    protected $table = 'kelurahans';
    public static $view = 'kelurahan_view';

    protected $fillable = ['id_kecamatan', 'id_kelurahan', 'nama_kelurahan', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
