<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dirjen extends Model
{
    use SoftDeletes;
    protected $table = 'dirjens';
    public static $view = 'dirjen_view';

    protected $fillable = ['id_kementrian','nama_dirjen', 'crt_id_user', 'upd_id_user','del_id_user'];
}
