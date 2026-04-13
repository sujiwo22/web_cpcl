<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penyuluh extends Model
{
    use SoftDeletes;
    protected $table = 'penyuluhs';
    public static $view = 'penyuluh_view';

    protected $fillable = [
        'id_kementrian',
        'nama_penyuluh',
        'contact_person',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
