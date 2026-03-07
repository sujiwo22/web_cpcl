<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use SoftDeletes;
    protected $table = 'provinsis';

    protected $fillable = ['id_provinsi','nama_provinsi', 'crt_id_user', 'upd_id_user','del_id_user'];
}
