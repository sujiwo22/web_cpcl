<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pesanWA extends Model
{
    use SoftDeletes;
    protected $table = 'pesan_was';

    protected $fillable = [
        'id_no_pengirim',
        'no_pengirim',
        'pesan',
        'status',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
