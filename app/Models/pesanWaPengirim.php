<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pesanWaPengirim extends Model
{
    use SoftDeletes;
    protected $table = 'pesan_wa_pengirims';
    public static $view = 'pesan_wa_pengirim_view';

    protected $fillable = ['id', 'no_pengirim', 'token', 'status', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
