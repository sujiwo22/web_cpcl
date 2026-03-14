<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tps extends Model
{
    use SoftDeletes;
    protected $table = 'tps';
    public static $view = 'tps_view';

    protected $fillable = ['nama_tps', 'id_kelurahan', 'alamat_tps', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
