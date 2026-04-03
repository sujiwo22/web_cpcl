<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pesanWaDetail extends Model
{
    use SoftDeletes;
    protected $table = 'pesan_wa_details';

    protected $fillable = [
        'id_pesan',
        'no_hp_penerima',
        'nama_penerima',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
