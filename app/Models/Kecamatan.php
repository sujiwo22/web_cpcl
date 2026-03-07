<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;
    protected $table = 'kecamatans';
    public static $view = 'kecamatan_view';

    protected $fillable = ['id_kota', 'id_kecamatan', 'nama_kecamatan', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
