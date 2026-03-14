<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelompok extends Model
{
    use SoftDeletes;
    protected $table = 'kelompoks';
    public static $view = 'kelompok_view';

    protected $fillable = ['nama_kelompok','alamat','id_kelurahan','no_hp','penanggung_jawab', 'crt_id_user', 'upd_id_user', 'del_id_user'];

}
