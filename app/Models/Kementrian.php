<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kementrian extends Model
{
    use SoftDeletes;
    protected $table = 'kementrians';
    public static $view = 'kementrian_view';

    protected $fillable = ['nama_kementrian','singkatan', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
