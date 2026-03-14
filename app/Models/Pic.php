<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pic extends Model
{
    use SoftDeletes;
    protected $table = 'pics';
    public static $view = 'pic_view';

    protected $fillable = [
        'nama_pic',
        'contact_person',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
