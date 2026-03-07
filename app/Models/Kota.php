<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kota extends Model
{
    use SoftDeletes;
    protected $table = 'kotas';

    protected $fillable = ['id_provinsi','id_kota','nama_kota', 'crt_id_user', 'upd_id_user','del_id_user'];
}
